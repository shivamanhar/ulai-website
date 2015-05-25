<?php

class ShopAdminUsers extends ShopAdminController
{
	protected $perPage = 15;
	protected $ordersPerPage = 6;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->perPage = (isset($_COOKIE["per_page"]) ? $_COOKIE["per_page"] : $this->perPage);
	}

	public function index($offset = 0, $orderField = "", $orderCriteria = "")
	{
		$model = SUserProfileQuery::create();

		if (ShopCore::$_GET["name"]) {
			$model = $model->where("SUserProfile.Name LIKE \"%" . encode(ShopCore::$_GET["name"]) . "%\"");
		}

		if (ShopCore::$_GET["dateCreated_f"] && ShopCore::$_GET["dateCreated_t"]) {
			$model = $model->where("FROM_UNIXTIME(SUserProfile.DateCreated, '%Y-%m-%d') >= ?", date("Y-m-d", strtotime(ShopCore::$_GET["dateCreated_f"])));
			$model = $model->where("FROM_UNIXTIME(SUserProfile.DateCreated, '%Y-%m-%d') <= ?", date("Y-m-d", strtotime(ShopCore::$_GET["dateCreated_t"])));
		}

		if (ShopCore::$_GET["email"]) {
			$model = $model->where("SUserProfile.UserEmail LIKE \"%" . encode(ShopCore::$_GET["email"]) . "%\"");
		}

		if (ShopCore::$_GET["role"]) {
			$model = $model->filterByRoleId(encode(ShopCore::$_GET["role"]));
		}

		if ((ShopCore::$_GET["amout_f"] != NULL) && (ShopCore::$_GET["amout_t"] != NULL)) {
			if (ShopCore::$_GET["amout_f"]) {
				$amout_f = encode(ShopCore::$_GET["amout_f"]);
			}
			else {
				$amout_f = 0;
			}

			if (ShopCore::$_GET["amout_t"]) {
				$amout_t = encode(ShopCore::$_GET["amout_t"]);
			}
			else {
				$amout_t = 0;
			}

			if ($amout_f < $amout_t) {
				$model = $model->where("SUserProfile.Amout > ?", $amout_f);
				$model = $model->where("SUserProfile.Amout < ?", $amout_t);
			}
		}

		if ($orderField !== '' && $orderCriteria !== '' && method_exists($model, 'filterBy' . $orderField)) {


            switch ($orderCriteria) {
                case 'ASC':
                    $model = $model->orderBy($orderField, Criteria::ASC);
                    $nextOrderCriteria = 'DESC';
                    break;

                case 'DESC':
                    $model = $model->orderBy($orderField, Criteria::DESC);
                    $nextOrderCriteria = 'ASC';
                    break;
            }
        }
        else
            $model->orderById('asc');

		$totalUsers = $this->_count($model);
		$model = $model->offset((int) ShopCore::$_GET["per_page"])->limit($this->perPage)->distinct()->find();
		$getData = ShopCore::$_GET;
		unset($getData["per_page"]);
		$queryString = "?" . http_build_query($getData);

		foreach ($model as $user ) {
			$amountPurchases[$user->getId()] = 0;

			foreach (SOrdersQuery::create()->leftJoin("SOrderProducts")->distinct()->filterByUserId($user->getId())->find() as $order ) {
				if ($order->getPaid() == true) {
					foreach ($order->getSOrderProductss() as $p ) {
						$amountPurchases[$user->getId()] += $p->getQuantity() * $p->getPrice();
					}

					$amountPurchases[$user->getId()] += $order->getDeliveryPrice();
				}
			}
		}

		if ($this->perPage < $totalUsers) {
			$this->load->library("Pagination");
			$config["base_url"] = site_url("admin/components/run/shop/users/index/?" . http_build_query(ShopCore::$_GET));
			$config["container"] = "shopAdminPage";
			$config["uri_segment"] = $this->uri->total_segments();
			$config["container"] = "shopAdminPage";
			$config["page_query_string"] = true;
			$config["total_rows"] = $totalUsers;
			$config["per_page"] = $this->perPage;
			$config["separate_controls"] = true;
			$config["full_tag_open"] = "<div class=\"pagination pull-left\"><ul>";
			$config["full_tag_close"] = "</ul></div>";
			$config["controls_tag_open"] = "<div class=\"pagination pull-right\"><ul>";
			$config["controls_tag_close"] = "</ul></div>";
			$config["next_link"] = lang("Next", "admin") . "&nbsp;&gt;";
			$config["prev_link"] = "&lt;&nbsp;" . lang("Prev", "admin");
			$config["cur_tag_open"] = "<li class=\"btn-primary active\"><span>";
			$config["cur_tag_close"] = "</span></li>";
			$config["prev_tag_open"] = "<li>";
			$config["prev_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li>";
			$config["next_tag_close"] = "</li>";
			$config["num_tag_close"] = "</li>";
			$config["num_tag_open"] = "<li>";
			$config["num_tag_close"] = "</li>";
			$this->pagination->num_links = 5;
			$this->pagination->initialize($config);
			$this->template->assign("paginator", $this->pagination->create_links_ajax());
		}

		$usersDatas = array();

		foreach ($model as $o ) {
			$usersDatas[] = $o->getFullName();
			$usersDatas[] = $o->getUserEmail();
			$usersDatas[] = $o->getDateCreated();
		}

		$usersDatas = array_unique($usersDatas);
		$roles = array();

		foreach ((array) $this->roles() as $role ) {
			$roles[$role->id] = $role->alt_name;
		}

		$this->setBackUrl();
		$this->render("list", array("model" => $model, "amountPurchases" => $amountPurchases, "totalUsers" => $totalUsers, "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "queryString" => $queryString, "usersDatas" => $usersDatas, "filter_url" => http_build_query(ShopCore::$_GET), "cur_uri_str" => base64_encode($this->uri->uri_string() . "?" . http_build_query(ShopCore::$_GET)), "roles" => $roles));
	}

	public function search($offset = 0, $orderField = "", $orderCriteria = "")
	{
		$model = SOrdersQuery::create();
		if (is_numeric(ShopCore::$_GET["status_id"]) && (ShopCore::$_GET["status_id"] != "-- none --")) {
			$model = $model->filterByStatus(ShopCore::$_GET["status_id"]);
		}

		if (ShopCore::$_GET["order_id"]) {
			$model = $model->where("SOrders.Id = ?", ShopCore::$_GET["order_id"]);
		}

		if (ShopCore::$_GET["created_from"]) {
			$model = $model->where("FROM_UNIXTIME(SOrders.DateCreated, '%Y-%m-%d') = ?", date("Y-m-d", strtotime(ShopCore::$_GET["date_from"])));
		}

		if (ShopCore::$_GET["created_to"]) {
			$model = $model->where("FROM_UNIXTIME(SOrders.DateCreated, '%Y-%m-%d') <= ?", date("Y-m-d", strtotime(ShopCore::$_GET["date_to"])));
		}

		if (ShopCore::$_GET["dateCreated_f"] && ShopCore::$_GET["dateCreated_t"]) {
			$model = $model->where("FROM_UNIXTIME(SUserProfile.DateCreated, '%Y-%m-%d') >= ?", date("Y-m-d", strtotime(ShopCore::$_GET["dateCreated_f"])));
			$model = $model->where("FROM_UNIXTIME(SUserProfile.DateCreated, '%Y-%m-%d') <= ?", date("Y-m-d", strtotime(ShopCore::$_GET["dateCreated_t"])));
		}

		if (ShopCore::$_GET["amout_f"] && ShopCore::$_GET["amout_t"]) {
			$model = $model->where("SUserProfile.Amout > ?", encode(ShopCore::$_GET["amout_f"]));
			$model = $model->where("SUserProfile.Amout < ?", encode(ShopCore::$_GET["amout_t"]));
		}

		if (ShopCore::$_GET["customer"]) {
			$model->_or()->where("SOrders.UserFullName LIKE ?", "%" . ShopCore::$_GET["customer"] . "%")->_or()->where("SOrders.UserEmail LIKE ?", "%" . ShopCore::$_GET["customer"] . "%")->_or()->where("SOrders.UserPhone LIKE ?", "%" . ShopCore::$_GET["customer"] . "%");
		}

		if (ShopCore::$_GET["amount_from"]) {
			$model->where("SOrders.TotalPrice >= ?", ShopCore::$_GET["amount_from"]);
		}

		if (ShopCore::$_GET["amount_to"]) {
			$model->where("SOrders.TotalPrice <= ?", ShopCore::$_GET["amount_to"]);
		}

		if (is_numeric(ShopCore::$_GET["paid"]) && (ShopCore::$_GET["paid"] != "-- none --")) {
			if (!ShopCore::$_GET["paid"]) {
				$model->where("SOrders.Paid IS NULL");
			}
			else {
				$model = $model->filterByPaid(true);
			}
		}

		$totalOrders = $this->_count($model);
		$nextOrderCriteria = '';
		if ($orderField !== '' && $orderCriteria !== '' && method_exists($products, 'filterBy' . $orderField)) {



            switch ($orderCriteria) {
                case 'ASC':
                    $model = $model->orderBy($orderField, Criteria::ASC);
                    $nextOrderCriteria = 'DESC';
                    break;

                case 'DESC':
                    $model = $model->orderBy($orderField, Criteria::DESC);
                    $nextOrderCriteria = 'ASC';
                    break;
            }
        }
        else
            $model->orderById('desc');

		$model = $model
                ->limit($this->perPage)
                ->offset((int) $offset)
                ->distinct()
                ->find();
		$getData = ShopCore::$_GET;
		unset($getData["per_page"]);
		$queryString = "?" . http_build_query($getData);
		$orderStatuses = SOrderStatusesQuery::create()->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$usersDatas = array();

		foreach ($model as $o ) {
			$usersDatas[] = $o->getUserFullName();
			$usersDatas[] = $o->getUserEmail();
			$usersDatas[] = $o->getUserPhone();
		}

		$usersDatas = array_unique($usersDatas);
		$this->load->library("pagination");
		$config["base_url"] = $this->createUrl("orders/search/");
		$config["container"] = "shopAdminPage";
		$config["uri_segment"] = 7;
		$config["total_rows"] = $totalOrders;
		$config["per_page"] = $this->perPage;
		$this->pagination->num_links = 6;
		$config["suffix"] = ($orderField != "" ? $orderField . "/" . $orderCriteria . $queryString : $queryString);
		$this->pagination->initialize($config);
		ShopCore::$_GET["status"] = -1;
		$this->render("list", array("model" => $model, "pagination" => $this->pagination->create_links_ajax(), "totalOrders" => $totalOrders, "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "queryString" => $queryString, "deliveryMethods" => SDeliveryMethodsQuery::create()->find(), "paymentMethods" => SPaymentMethodsQuery::create()->find(), "orderStatuses" => $orderStatuses, "usersDatas" => $usersDatas));
	}

	private function roles()
	{
		$this->db->select("shop_rbac_roles.*", false);
		$this->db->select("shop_rbac_roles_i18n.alt_name", false);
		$this->db->where("locale", MY_Controller::getCurrentLocale());
		$this->db->join("shop_rbac_roles_i18n", "shop_rbac_roles_i18n.id = shop_rbac_roles.id");
		$roles = $this->db->get("shop_rbac_roles")->result();
		return $roles;
	}

	public function create()
	{
		$model = new SUserProfile();

		if ($_POST) {
			$this->load->model("dx_auth/users", "user2");
			$val = $this->form_validation->set_rules($model->rules("create"));
			$this->form_validation->set_rules("Phone", lang("Phone"), "trim|min_length[5]|max_length[20]|xss_clean|callback_check_phone");
			$val = $model->validateCustomData($val);

			if (!$val->run()) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$hook = get_hook("users_create_set_val_rules") ? eval ($hook) : NULL;
				$email = $_POST["UserEmail"];
				$role = $_POST["Role"];

				if (0 < $this->user2->check_email($email)->num_rows()) {
					showMessage(lang("A user with this email is already registered.", "admin"), "", "r");
					exit();
				}

				$this->load->helper("string");
				$key = random_string("alnum", 5);

				if (ShopCore::$ci->dx_auth->register($val->set_value("Name"), $val->set_value("Password"), $val->set_value("UserEmail"), $val->set_value("Address"), $key, $val->set_value("Phone"), false)) {
					$user_info = ShopCore::$ci->user2->get_user_by_email($email)->row_array();
					$model = SUserProfileQuery::create()->findOneById($user_info["id"]);
					$model->setRoleId($role);
					$model->setKey($key);
					$model->setPhone($_POST["Phone"]);
					$model->setAddress($_POST["Address"]);
					$model->save();
					CMSFactory\Events::create()->registerEvent(array("user" => $model), "ShopAdminUser:create");
					CMSFactory\Events::runFactory();
					$hook = get_hook("users_user_created") ? eval ($hook) : NULL;
					$this->user2->set_role($user_info["id"], $role);
					$user_id = $this->db->order_by("id", "desc")->get("users")->row()->id;
					$this->lib_admin->log(lang("User created", "admin") . ". Id: " . $user_id);
					showMessage(lang("User created", "admin"));
					$action = $_POST["action"];

					if ($action == "close") {
						pjax("/admin/components/run/shop/users/edit/" . $model->getId());
					}
					else {
						pjax("/admin/components/run/shop/users/index");
					}
				}
				else {
					showMessage(validation_errors(), "", "r");
				}
			}
		}
		else {
			$this->render("create", array("model" => $model, "roles" => $this->roles()));
		}
	}

	public function edit($id, $offset = 0, $ordersList = NULL)
	{
		$model = SUserProfileQuery::create()->filterById((int) $id)->findOne();

		if ($model === NULL) {
			$this->error404(lang("User not found", "admin"));
		}

		if (!empty($_POST)) {
			$validation = $this->form_validation->set_rules($model->rules("edit"));

			if (strlen($this->input->post("new_pass")) !== 0) {
				$this->form_validation->set_rules("new_pass", lang("New password"), "trim|min_length[5]|max_length[50]|xss_clean");
				$this->form_validation->set_rules("new_pass_conf", lang("New password confirm"), "matches[new_pass]");
			}

			$validation = $model->validateCustomData($validation);

			if ($validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				if ($this->input->post("new_pass")) {
					$noCryptPassword = $_POST["new_pass"];
					$_POST["Password"] = crypt(ShopCore::$ci->dx_auth->_encode($_POST["new_pass"]));
				}

				unset($_POST["new_pass"]);
				unset($_POST["new_pass_conf"]);
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Shop", "admin") . " - " . lang("Changes have been saved", "admin") . "<a href=\"" . site_url("/admin/components/run/shop/users/edit/" . $id) . "\">" . $model->getFullName() . "</a>");
				$ReplaceData = array("user_name" => $_POST["Name"], "password" => $noCryptPassword);

				if ($ReplaceData["password"] != NULL) {
					cmsemail\email::getInstance()->sendEmail($_POST["UserEmail"], "change_password", $ReplaceData);
				}

				$this->lib_admin->log(lang("User edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes have been saved", "admin"));
				$action = $_POST["action"];

				if ($action == "close") {
					pjax("/admin/components/run/shop/users/edit/" . $id);
				}
				else {
					pjax($this->getBackUrl());
				}
			}
		}
		else {
			$amountPurchases = 0;

			foreach (SOrdersQuery::create()->leftJoin("SOrderProducts")->distinct()->filterByUserId($id)->find() as $order ) {
				if ($order->getPaid() == true) {
					foreach ($order->getSOrderProductss() as $p ) {
						$amountPurchases += $p->getQuantity() * $p->getPrice();
					}

					$amountPurchases += $order->getDeliveryPrice();
				}
			}

			$WishListData = unserialize($model->getWishListData());

			if (is_array($WishListData)) {
				$newData = array();
				$NewCollection = array();
				$ids = array_map("array_shift", $WishListData);

				if (0 < sizeof($ids)) {
					$collection = SProductsQuery::create()->findPks(array_unique($ids));
					$i = 0;
					
					 for ($i = 0; $i < sizeof($collection); $i++) {
                        $newCollection[$collection[$i]->getId()] = $collection[$i];
                    }


					foreach ($WishListData as $key => $item ) {
						if ($NewCollection[$item[0]] !== NULL) {
							$item["model"] = $NewCollection[$item[0]];
							$productVariant = SProductVariantsQuery::create()->filterById($item[1])->findOne();
							$item["variantName"] = $productVariant->getName();
							$item["price"] = money_format("%i", $productVariant->getPrice());
							$newData[$key] = $item;
						}
					}
				}
			}

			$ordersModel = SOrdersQuery::create()->orderById("desc")->filterByUserId($id);
			$totalOrders = $this->_count($ordersModel);
			$ordersModel = $ordersModel->distinct()->limit($this->ordersPerPage)->offset((int) $offset)->find();
			$orderStatuses = SOrderStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
			$this->load->library("pagination");
			$config["base_url"] = $this->createUrl("users/edit/" . $id . "/");
			$config["container"] = "shopEditUserOrders";
			$config["uri_segment"] = 8;
			$config["total_rows"] = $totalOrders;
			$config["per_page"] = $this->ordersPerPage;
			$this->pagination->num_links = 6;
			$config["suffix"] = "true";
			$this->pagination->initialize($config);

			if ($ordersList) {
				$this->render("edit_orders_list", array("ordersModel" => $ordersModel, "orderStatuses" => $orderStatuses, "pagination" => $this->pagination->create_links_ajax()));
			}
			else {
				$this->render("edit", array("model" => $model, "amountPurchases" => $amountPurchases, "newData" => $newData, "ordersModel" => $ordersModel, "orderStatuses" => $orderStatuses, "pagination" => $this->pagination->create_links_ajax(), "roles" => $this->roles(), "back_url" => $this->getBackUrl()));
			}
		}
	}

	private function getBackUrl()
	{
		$users_back_url = ($this->session->userdata("users_back_url") ? $this->session->userdata("users_back_url") : site_url("/admin/components/run/shop/users"));
		return $users_back_url;
	}

	private function setBackUrl()
	{
		$previous = $_SERVER["REQUEST_URI"];
		$users_back_url = (strstr($previous, "shop/users") && !strstr($previous, "shop/users/edit") ? $previous : site_url("/admin/components/run/shop/users"));
		$this->session->set_userdata("users_back_url", $users_back_url);
	}

	public function check_phone($value)
	{
			$value = trim($value);

			if (preg_match_all("/^[\+\-0-9\(\)]{5,20}$/", $value)) {
				return $value;
			}


			$this->form_validation->set_message("phone_check", lang("Wrong phone format", "saas"));
			return false;
		
	}

	public function deleteAll()
	{
		if (empty($_POST["ids"])) {
			showMessage(lang("No data transmitted", "admin"), "", "r");
			exit();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SUserProfileQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $order ) {
					$order->delete();
				}

				$this->lib_admin->log(lang("User deleted", "admin") . ". Ids: " . implode(", ", $_POST["ids"]));
				showMessage(lang("Members removed", "admin"));
			}
		}
	}

	protected function _count($object)
	{
		$object = clone $object;
		return $object->count();
	}

	public function auto_complite($type)
	{
		$s_limit = $this->input->get("limit");
		$s_coef = $this->input->get("term");
		$model = SUserProfileQuery::create();

		if ($type == "name") {
			$model = $model->where("SUserProfile.Name LIKE \"%" . $s_coef . "%\"");
		}
		else {
			$model = $model->where("SUserProfile.UserEmail LIKE \"%" . $s_coef . "%\"");
		}

		$model = $model->limit($s_limit)->find();

		foreach ($model as $product ) {
			if ($type == "name") {
				$response[] = array("value" => ShopCore::encode($product->getName()));
			}
			else if ($type == "email") {
				$response[] = array("value" => ShopCore::encode($product->getUserEmail()));
			}
		}

		echo json_encode($response);
	}
}


?>
