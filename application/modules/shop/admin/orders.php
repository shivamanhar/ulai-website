<?php

class ShopAdminOrders extends ShopAdminController
{
	protected $perPage = 12;
	public $defaultLanguage;

	public function __construct()
	{
		parent::__construct();
		$lang = new MY_Lang();
		$lang->load();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->load->helper("Form");
		$this->defaultLanguage = getDefaultLanguage();
		$this->load->library("form_validation");
	}

	public function index()
	{
		$offset = 0;
		$OrdersDateCreate = $this->db->query("SELECT MIN(date_created) AS oldest_date, MAX(date_created) AS newest_date FROM `shop_orders`");

		if ($OrdersDateCreate) {
			$OrdersDateCreate = $OrdersDateCreate->row();
		}

		$model = SOrdersQuery::create()->addSelectModifier("SQL_CALC_FOUND_ROWS");
		unset($pids);
		if (is_numeric(ShopCore::$_GET["status_id"]) && (ShopCore::$_GET["status_id"] != "-- none --")) {
			$model = $model->filterByStatus(ShopCore::$_GET["status_id"]);
		}

		if (ShopCore::$_GET["order_id"]) {
			$model = $model->where("SOrders.Id = ?", ShopCore::$_GET["order_id"]);
		}

		if (ShopCore::$_GET["created_from"]) {
			$model = $model->where("FROM_UNIXTIME(SOrders.DateCreated, '%Y-%m-%d') >= ?", date("Y-m-d", strtotime(ShopCore::$_GET["created_from"])));
		}

		if (ShopCore::$_GET["created_to"]) {
			$model = $model->where("FROM_UNIXTIME(SOrders.DateCreated, '%Y-%m-%d') <= ?", date("Y-m-d", strtotime(ShopCore::$_GET["created_to"])));
		}

		if ($_GET["product_id"]) {
			$model = $model->leftJoinSOrderProducts()->where("SOrderProducts.ProductId = ?", $_GET["product_id"]);
		}

		if (!empty($_GET["product"])) {
			$model = $model->leftJoinSOrderProducts()->where("SOrderProducts.ProductName LIKE ?", "%" . $_GET["product"] . "%");
		}

		if (ShopCore::$_GET["customer"]) {
			$model = $model->_and()->where("SOrders.UserFullName LIKE ?", "%" . ShopCore::$_GET["customer"] . "%")->_or()->where("SOrders.UserEmail LIKE ?", "%" . ShopCore::$_GET["customer"] . "%")->_or()->where("SOrders.UserPhone LIKE ?", "%" . ShopCore::$_GET["customer"] . "%");
		}

		if (ShopCore::$_GET["amount_from"]) {
			$model = $model->where("SOrders.TotalPrice >= ?", ShopCore::$_GET["amount_from"]);
		}

		if (ShopCore::$_GET["amount_to"]) {
			$model = $model->where("SOrders.TotalPrice <= ?", ShopCore::$_GET["amount_to"]);
		}

		if (ShopCore::$_GET["paid"] != "-- none --") {
			if (ShopCore::$_GET["paid"] === "0") {
				$model = $model->where("SOrders.Paid IS NULL")->_or()->where("SOrders.Paid = 0");
			}
			else if (ShopCore::$_GET["paid"] === "1") {
				$model = $model->filterByPaid(true);
			}
		}

		if (((ShopCore::$_GET["orderMethod"] != "") && (ShopCore::$_GET["orderCriteria"] != "") && method_exists($model, "filterBy" . ShopCore::$_GET["orderMethod"])) || (ShopCore::$_GET["orderMethod"] == "Id")) {
			switch (ShopCore::$_GET["orderCriteria"]) {
			case "ASC":
				$nextOrderCriteria = "DESC";
				$nOArr = "&darr;";
				$model = $model->orderBy(ShopCore::$_GET["orderMethod"], Propel\Runtime\ActiveQuery\Criteria::ASC);
			case "DESC":
				$nextOrderCriteria = "ASC";
				$nOArr = "&uarr;";
			}
		}
		else {
			$model->orderById("DESC");
		}

		$this->perPage = $this->paginationVariant($_SESSION["pagination"]);
		$model = $model->limit($this->perPage)->offset((int) ShopCore::$_GET["per_page"])->distinct()->find();
		$totalOrders = $this->getTotalRow();
		$usersDatas = array();
		$ProductDatas = array();
		$pids = array();

		foreach ($model as $o ) {
			$usersDatas[] = $o->getUserFullName();
			$usersDatas[] = $o->getUserEmail();
			$usersDatas[] = $o->getUserPhone();

			if ($o->getSOrderProductss()) {
				foreach ($o->getSOrderProductss() as $p ) {
					if (is_object($p)) {
						if (!in_array($p->getProductId(), $pids)) {
							$pids[] = $p->getProductId();
							$ProductDatas[] = array("v" => $p->getProductId(), "label" => $p->getProductName());
						}
					}
				}
			}
		}

		$getData = ShopCore::$_GET;
		unset($getData["per_page"]);
		$queryString = "?" . http_build_query($getData);
		$orderStatuses = SOrderStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$this->load->library("Pagination");
		$config["base_url"] = site_url("admin/components/run/shop/orders/index/?") . http_build_query(ShopCore::$_GET);
		$config["container"] = "shopAdminPage";
		$config["uri_segment"] = $this->uri->total_segments();
		$config["page_query_string"] = true;
		$config["total_rows"] = $totalOrders;
		$config["per_page"] = $this->perPage;
		$config["separate_controls"] = true;
		$config["full_tag_open"] = "<div class=\"pagination pull-left\"><ul>";
		$config["full_tag_close"] = "</ul></div>";
		$config["controls_tag_open"] = "<div class=\"pagination pull-right\"><ul>";
		$config["controls_tag_close"] = "</ul></div>";
		$config["next_link"] = lang("Forward&nbsp;", "admin");
		$config["prev_link"] = lang("&nbsp;Back", "admin");
		$config["cur_tag_open"] = "<li class=\"btn-primary active\"><span>";
		$config["cur_tag_close"] = "</span></li>";
		$config["prev_tag_open"] = "<li>";
		$config["prev_tag_close"] = "</li>";
		$config["next_tag_open"] = "<li>";
		$config["next_tag_close"] = "</li>";
		$config["num_tag_close"] = "</li>";
		$config["num_tag_open"] = "<li>";
		$config["num_tag_close"] = "</li>";
		$config["last_tag_open"] = "<li>";
		$config["last_tag_close"] = "</li>";
		$config["first_tag_open"] = "<li>";
		$config["first_tag_close"] = "</li>";
		$this->pagination->num_links = 5;
		$this->pagination->initialize($config);
		$this->template->assign("pagination", $this->pagination->create_links_ajax());
		ShopCore::$_GET["status"] = -1;
		$this->render("list", array("oldest_order_date" => $OrdersDateCreate, "model" => $model, "totalOrders" => $totalOrders, "perPage" => $this->perPage, "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "paginationVariant" => $this->paginationVariant($_SESSION["pagination"]), "queryString" => $queryString, "deliveryMethods" => SDeliveryMethodsQuery::create()->find(), "paymentMethods" => SPaymentMethodsQuery::create()->find(), "orderStatuses" => $orderStatuses, "usersDatas" => array_unique($usersDatas), "productsDatas" => $ProductDatas, "offset" => $offset));
	}

	public function paginationVariant($int = false, $ref = false)
	{
		if (($int == false) || ($int == NULL)) {
			$_SESSION["pagination"] = 12;
		}
		else {
			$_SESSION["pagination"] = $int;
		}

		if ($ref == true) {
			pjax("/admin/components/run/shop/orders");
		}

		return $_SESSION["pagination"];
	}

	public function edit($id)
	{
		$model = SOrdersQuery::create()->findPk((int) $id);

		if (NULL === $model) {
			$this->error404(lang("Order not found", "admin"));
		}

		$price_total = $model->getTotalPrice();
		$criteriaPaid = $model->getPaid();
		$statusOldPaid = $criteriaPaid;
		$_SESSION["recount"] = true;
		$statusHistory = SOrderStatusHistoryQuery::create()->filterByOrderId((int) $id)->find();
		$usersName = array();
		$ci = get_instance();
		$ci->load->model("dx_auth/users", "users");

		foreach ($statusHistory as $status ) {
			if (($query = $ci->users->get_user_by_id($status->getUserId())) && ($query->num_rows() == 1)) {
				$row = $query->row();
				$usersName[$status->getId()] = array("name" => $row->username, "role" => $row->role_id);
			}
		}

		$oldStatusId = SOrdersQuery::create()->filterById($id)->findOne()->getStatus();

		if ($_POST) {
			$_POST["Paid"] = (bool) $_POST["Paid"];
			$_POST["StatusId"] = $this->input->post("Status");
			$validation = $this->form_validation->set_rules("UserEmail");
			$validation = $model->validateCustomData($validation);

			if ($validation->run()) {
				$model->fromArray($_POST);
				$deliveryMethod = SDeliveryMethodsQuery::create()->findPk((int) $_POST["shop_orders"]["delivery_method"]);
				if ($deliveryMethod === NULL) {
					$deliveryMethod = 0;
					$deliveryPrice = 0;
				}
				else {
					$freeFrom = $deliveryMethod->getFreeFrom();
					$deliveryPrice = (($freeFrom < $model->getTotalPrice()) & (0 < $freeFrom) ? 0 : $deliveryMethod->getPrice());
					$deliveryMethod = $deliveryMethod->getId();
				}

				$paymentMethod = SPaymentMethodsQuery::create()->findPk((int) $_POST["shop_orders"]["payment_method"]);

				if ($paymentMethod === NULL) {
					$paymentMethod = 0;
				}
				else {
					$paymentMethod = $paymentMethod->getId();
				}

				$model->setDeliveryMethod($deliveryMethod);
				$model->setDeliveryPrice($deliveryPrice);
				$model->setPaymentMethod($paymentMethod);
				$model->save();
				$this->recountUserAmount($model, $statusOldPaid);

				if ($oldStatusId != (int) $_POST["Status"]) {
					$modelOrder = new SOrderStatusHistory();
					$this->form_validation->set_rules($modelOrder->rules());

					if ($this->form_validation->run($this) == false) {
						showMessage(validation_errors(), "", "r");
					}
					else {
						$modelOrder->setOrderId($id)->setStatusId($_POST["Status"])->setUserId($this->dx_auth->get_user_id())->setDateCreated(time())->setComment($_POST["Comment"]);
						$modelOrder->save();
						$modelOrderStatus = SOrderStatusesI18nQuery::create()->filterByLocale(MY_Controller::defaultLocale())->filterById((int) $_POST["Status"])->findOne();

						if ($_POST["Notify"]) {
							cmsemail\email::getInstance()->sendEmail($model->getUserEmail(), "change_order_status", array("status" => $modelOrderStatus->getName(), "comment" => $_POST["Comment"], "userName" => $model->getUserFullName(), "userEmail" => $model->getUserEmail(), "userPhone" => $model->getUserPhone(), "userDeliver" => $model->getUserDeliverTo(), "orderLink" => shop_url("order/view/" . $model->getKey())));
						}

						showMessage(lang("Order status changed", "admin"));
					}
				}

				CMSFactory\Events::create()->registerEvent(array("model" => $model));
				CMSFactory\Events::runFactory();
				$this->lib_admin->log(lang("Order edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes saved", "admin"));

				if (isset($_POST["action"]) && ($_POST["action"] == "edit")) {
					pjax("/admin/components/run/shop/orders/edit/" . $model->getId());
				}
				else {
					pjax("/admin/components/run/shop/orders/");
				}
			}
			else {
				showMessage(validation_errors(), "", "r");
			}
		}
		else {
			$criteria = SOrderProductsQuery::create()->orderById(Propel\Runtime\ActiveQuery\Criteria::ASC);

			foreach ($model->getSOrderProductss($criteria) as $sOrderProduct ) {
				if (0 < $sOrderProduct->getKitId()) {
					if (!isset($kits[$sOrderProduct->getKitId()]["total"])) {
						$kits[$sOrderProduct->getKitId()]["total"] = 0;
					}

					if (!isset($kits[$sOrderProduct->getKitId()]["price"])) {
						$kits[$sOrderProduct->getKitId()]["price"] = 0;
					}

					++$kits[$sOrderProduct->getKitId()]["total"];
					$kits[$sOrderProduct->getKitId()]["price"] = $kits[$sOrderProduct->getKitId()]["price"] + $sOrderProduct->toCurrency();
				}
			}


			foreach ($model->getSOrderProductss() as $key => $number ) {
				$products = SProductVariantsQuery::create()->filterById($number->getVariantId())->find();

				if ($products[0]) {
					$number->setVirtualColumn("number", $products[0]->getNumber());
				}
			}

			if ($model->getDeliveryMethod() != 0) {
				$freeFrom = SDeliveryMethodsQuery::create()->findPk($model->getDeliveryMethod())->getFreeFrom();
			}
			else {
				$freeFrom = 0;
			}

			$paymentMethods = ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($model->getDeliveryMethod())->find();

			foreach ($paymentMethods as $paymentMethod ) {
				$PaymentMethodId[] = $paymentMethod->getPaymentMethodId();
			}

			$paymentMethod = SPaymentMethodsQuery::create()->filterByActive(true)->joinWithI18n(MY_Controller::defaultLocale())->where("SPaymentMethods.Id IN ?", $PaymentMethodId)->orderByPosition()->find();
			$deliveryMethods = SDeliveryMethodsQuery::create()->joinWithI18n($this->defaultLanguage["identif"], Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN)->orderBy("SDeliveryMethodsI18n.Name", Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
			$this->render("edit", array("model" => $model, "discount" => $model->getDiscount(), "freeFrom" => $freeFrom, "kits" => $kits, "deliveryMethods" => $deliveryMethods, "paymentMethods" => $paymentMethod, "statusHistory" => $statusHistory, "usersName" => $usersName));
		}
	}

	private function recountUserAmount(SOrders $orderModel, $statusOldPaid)
	{
		if (!0 < (int) $orderModel->getUserId()) {
			return;
		}

		$amount = $this->db->select("amout")->get_where("users", array("id" => $orderModel->getUserId()))->row()->amout;
		$total_price = $this->db->select("total_price")->where(array("id" => $orderModel->getId()))->get("shop_orders")->row()->total_price;

		if ($statusOldPaid != $orderModel->getPaid()) {
			if ($orderModel->getPaid() == 1) {
				$amount += $total_price;
			}
			else {
				$amount -= $total_price;
			}
		}

		$this->db->where("id", $orderModel->getUserId())->limit(1)->update("users", array("amout" => str_replace(",", ".", $amount)));
	}

	public function test()
	{
		$order = SOrdersQuery::create()->findPk(96);
	}

	public function recount_amount($user_id = NULL)
	{
		$this->db->select("total_price");
		$this->db->where("user_id", $user_id);
		$res = $this->db->get("shop_orders")->result_array();
		$sum = 0;

		foreach ($res as $value ) {
			$sum += $value["total_price"];
		}

		return $sum;
	}

	public function changeStatus()
	{
		$orderId = (int) $_POST["OrderId"];
		$StatusId = (int) $_POST["StatusId"];
		$model = SOrdersQuery::create()->findPk($orderId);
		$newStatusId = SOrderStatusesQuery::create()->findPk((int) $StatusId);

		if (!empty($newStatusId)) {
			if ($model !== NULL) {
				$model->setStatus($StatusId);
				$model->save();

				if (!empty($_POST)) {
					$model = new SOrderStatusHistory();
					$this->form_validation->set_rules($model->rules());

					if ($this->form_validation->run($this) == false) {
						showMessage(validation_errors());
					}
					else {
						$model->setOrderId($orderId)->setStatusId($StatusId)->setUserId($this->dx_auth->get_user_id())->setDateCreated(time())->setComment($_POST["Comment"]);
						$model->save();
						showMessage(lang("Order Status changed", "admin"));
					}
				}
			}
		}
	}

	public function changePaid()
	{
		$orderId = (int) $_POST["orderId"];
		$model = SOrdersQuery::create()->findPk($orderId);

		if ($model !== NULL) {
			if ($model->getPaid() == true) {
				$model->setPaid(false);
			}
			else {
				$model->setPaid(true);
			}

			$model->save();
			echo (int) $model->getPaid();
			$ordersesQuery = $this->db->query("SELECT amout FROM shop_user_profile WHERE user_id = " . $model->getUserId());
			$orderses = $ordersesQuery->row();

			if ($model->getPaid() == 1) {
				$summAdd = ($orderses->amout + $model->getTotalPrice()) - Currency\Currency::create()->convert($model->getDiscount());
			}
			else {
				$summAdd = $orderses->amout - $model->getTotalPrice() - Currency\Currency::create()->convert($model->getDiscount());
			}

			$data = array("amout" => $summAdd);
			$this->db->where("user_id", $model->getUserId());
			$this->db->update("shop_user_profile", $data);
		}
	}

	public function delete()
	{
		$model = SOrdersQuery::create()->findPk((int) $_POST["orderId"]);

		if ($model) {
			$model->delete();
		}
	}

	public function ajaxDeleteOrders()
	{
		if (sizeof(0 < $_POST["ids"])) {
			$model = SOrdersQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $order ) {
					CMSFactory\Events::create()->registerEvent(array("order" => $order), "ShopAdminOrder:ajaxDeleteOrders");
					CMSFactory\Events::runFactory();
					$order->delete();
					$UserId = $this->recount_amount($order->getUserId());
					$data = array("amout" => $UserId);
					$this->db->where("id", $order->getUserId());
					$this->db->update("users", $data);
				}

				$this->lib_admin->log(lang("Order deleted", "admin") . ". Id: " . $order->getId());
				showMessage(lang("Orders are removed", "admin"), lang("The operation was successful", "admin"));
			}
		}
	}

	public function ajaxChangeOrdersStatus($status)
	{
		if (sizeof(0 < $_POST["ids"])) {
			$model = SOrdersQuery::create()->findPks($_POST["ids"]);
			$newStatusId = SOrderStatusesQuery::create()->findPk((int) $status);
			$statusEmail = SOrderStatusesI18nQuery::create()->filterById($status)->findOne();

			if (!empty($newStatusId)) {
				if (!empty($model)) {
					foreach ($model as $order ) {
						$order->setStatus((int) $status);
						$order->save();
						$modelOrderStatusHistory = new SOrderStatusHistory();
						$modelOrderStatusHistory->setOrderId($order->getId())->setStatusId($status)->setUserId($this->dx_auth->get_user_id())->setDateCreated(time());
						$modelOrderStatusHistory->save();
						cmsemail\email::getInstance()->sendEmail($order->getUserEmail(), "change_order_status", array("status" => $statusEmail->getName(), "userName" => $order->getUserFullName(), "userEmail" => $order->getUserEmail(), "userPhone" => $order->getUserPhone(), "userDeliver" => $order->getUserDeliverTo(), "orderLink" => shop_url("order/view/" . $order->getKey())));



					}

					CMSFactory\Events::create()->registerEvent(array("model" => $model));
					CMSFactory\Events::runFactory();
					showMessage(lang("Order Status changed", "admin"), lang("The operation was successful", "admin"));
				}
			}
		}
	}


	public function ajaxChangeOrdersPaid($paid)
	{
		if (sizeof(0 < $_POST["ids"])) {
			$model = SOrdersQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $order ) {
					$_SESSION["recount"] = true;

					if ($order->getPaid() == $paid) {
						continue;
					}

					$order->setPaid($paid);
					$order->save();
					$this->recountUserAmount($order);

					if ($paid) {
						$message = lang("Order paid status changed to Paid", "admin") . ". " . lang("Id:", "admin") . " " . $order->getId();
					}
					else {
						$message = lang("Order paid status changed to Not paid", "admin") . ". " . lang("Id:", "admin") . " " . $order->getId();
					}

					$this->lib_admin->log($message);
				}

				showMessage(lang("Payment status of orders changed", "admin"), lang("Saved", "admin"));
			}
		}
	}

	public function ajaxEditWindow($Id)
	{
		$orderedProduct = SOrderProductsQuery::create()->filterById((int) $Id)->findOne();
		$this->render("_editWindow", array("product" => SProductsQuery::create()->filterById($orderedProduct->getProductId())->findOne(), "orderedProduct" => $orderedProduct));
	}

	public function editKit($orderId, $kitId)
	{
		$model = SOrdersQuery::create()->findPk((int) $orderId);

		if ($_POST) {
		}
		else if ($model) {
			$criteria = SOrderProductsQuery::create()->filterByKitId((int) $kitId);
			$sOrderProducts = $model->getSOrderProductss($criteria);
		}
		else {
			$sOrderProducts = $model->getSOrderProductss($criteria);
			$this->render("editKitWindow", array("sOrderProducts" => $sOrderProducts, "orderId" => $orderId, "kitId" => $kitId));
		}
	}

	public function ajaxEditAddToCartWindow($orderId)
	{
		$this->render("_editAddToCartWindow", array("order" => SOrdersQuery::create()->filterById($orderId)->findOne()));
	}

	public function ajaxDeleteProduct($Id)
	{
		$orderedProduct = SOrderProductsQuery::create()->filterById((int) $Id)->findOne();

		if ($orderedProduct == NULL) {
			return;
		}

		$countProducts = $this->db->select("*, IF (kit_id IS NOT NULL, kit_id, id) AS forgroup", false)->where("order_id", $orderedProduct->getOrderId())->group_by("forgroup")->get("shop_orders_products")->num_rows();

		if ($countProducts <= 1) {
			showMessage(lang("You can not delete the last item from the order", "admin"), "", "r");
			return;
		}

		if ($orderedProduct->getKitId() != NULL) {
			$kitProducts = SOrderProductsQuery::create()->filterByKitId($orderedProduct->getKitId())->filterByOrderId($orderedProduct->getOrderId())->find();
			$kitProducts->delete();
			$oId = $orderedProduct->getOrderId();
			$order = SOrdersQuery::create()->findPk($oId);
			$order->updateTotalPrice();
			$order->save();
			$order->updateDeliveryPrice();
			$order->save();
			showMessage(lang("Product is removed from the Order", "admin"));
			pjax("/admin/components/run/shop/orders/edit/" . $order->getId() . "#productsInCart");
			return;
		}

		if ($orderedProduct != NULL) {
			$oId = $orderedProduct->getOrderId();
			$orderedProduct->delete();
			$order = SOrdersQuery::create()->findPk($oId);
			$order->updateTotalPrice();
			$order->save();
			$order->updateDeliveryPrice();
			$order->save();
			showMessage(lang("Product is removed from the Order", "admin"));
			pjax("/admin/components/run/shop/orders/edit/" . $order->getId() . "#productsInCart");
		}
	}

	public function ajaxGetProductsList()
	{
		$products = new SProductsQuery();

		if (!empty(ShopCore::$_GET["term"])) {
			$text = ShopCore::$_GET["term"];

			if (!strpos($text, "%")) {
				$text = "%" . $text . "%";
			}

			if ($type != "number") {
				$products->joinWithI18n(MY_Controller::defaultLocale())->filterById(ShopCore::$_GET["term"])->_or()->useI18nQuery(MY_Controller::defaultLocale())->filterByName("%" . ShopCore::$_GET["term"] . "%")->endUse()->_or()->useProductVariantQuery()->filterByNumber("%" . ShopCore::$_GET["term"] . "%")->endUse();
			}
			else {
				$products->useProductVariantQuery()->filterByNumber("%" . ShopCore::$_GET["term"] . "%")->endUse();
			}
		}

		if (!empty(ShopCore::$_GET["noids"])) {
			$products->filterById(ShopCore::$_GET["noids"], Propel\Runtime\ActiveQuery\Criteria::NOT_IN);
		}

		$products = $products->limit(isset($_GET["limit"]) ? $_GET["limit"] : 10)->distinct()->find();
		$variants = SProductVariantsQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->filterBySProducts($products)->orderById(Propel\Runtime\ActiveQuery\Criteria::DESC)->find();
		$pVariants = array();
		$pProductIndex = $products->toKeyIndex("id");

		foreach ($variants as $variant ) {
			$name = $variant->getName() ?: $pProductIndex[$variant->getProductId()]->getName();
			$pVariants[$variant->getProductId()][$variant->getId()]["name"] = $name;
			$pVariants[$variant->getProductId()][$variant->getId()]["price"] = $variant->getPrice();
			$pVariants[$variant->getProductId()][$variant->getId()]["number"] = $variant->getNumber();
		}

		$response = array();

		foreach ($products as $product ) {
			$pNameVol = ShopCore::encode($product->getId() . " - " . $product->getName());
			$response[] = array("label" => $pNameVol, "name" => ShopCore::encode($product->getName()), "id" => $product->getId(), "value" => $product->getId(), "category" => $product->getCategoryId(), "variants" => $pVariants[$product->getId()], "cs" => Currency\Currency::create()->getSymbol());
		}

		echo json_encode($response);
	}

	public function ajaxGetProductList($type = NULL)
	{
		$products = new SProductsQuery();

		if (!empty(ShopCore::$_GET["term"])) {
			$text = ShopCore::$_GET["term"];

			if (!strpos($text, "%")) {
				$text = "%" . $text . "%";
			}

			if ($type != "number") {
				$products->joinWithI18n(MY_Controller::defaultLocale())->filterById(ShopCore::$_GET["term"])->_or()->useI18nQuery(MY_Controller::defaultLocale())->filterByName("%" . ShopCore::$_GET["term"] . "%")->endUse()->_or()->useProductVariantQuery()->filterByNumber("%" . ShopCore::$_GET["term"] . "%")->endUse();
			}
			else {
				$products->useProductVariantQuery()->filterByNumber("%" . ShopCore::$_GET["term"] . "%")->endUse();
			}
		}

		if (!empty(ShopCore::$_GET["noids"])) {
			$products->filterById(ShopCore::$_GET["noids"], Propel\Runtime\ActiveQuery\Criteria::NOT_IN);
		}

		$products = $products->limit(isset($_GET["limit"]) ? $_GET["limit"] : 10)->distinct()->find();
		$variants = SProductVariantsQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->filterBySProducts($products)->orderById(Propel\Runtime\ActiveQuery\Criteria::DESC)->find();

		foreach ($variants as $variant ) {
			$pVariants[$variant->getProductId()][$variant->getId()]["name"] = ShopCore::encode($variant->getName());
			$pVariants[$variant->getProductId()][$variant->getId()]["price"] = $variant->getPrice();
			$pVariants[$variant->getProductId()][$variant->getId()]["number"] = $variant->getNumber();
		}

		foreach ($products as $key => $product ) {
			if ($pVariants[$product->getId()]) {
				foreach ($pVariants[$product->getId()] as $key => $variant ) {
					$name = ($variant["name"] ? $variant["name"] : $product->getName());
					$pNameVol = ShopCore::encode($product->getId() . " - " . $name . " (" . $variant["number"] . ")");
					$response[] = array("number" => $variant["number"] ? $variant["number"] : "", "label" => $pNameVol, "name" => ShopCore::encode($product->getName()), "id" => $product->getId(), "value" => $product->getId(), "category" => $product->getCategoryId(), "variants" => $pVariants[$product->getId()], "cs" => Currency\Currency::create()->getSymbol());
				}
			}
		}

		echo json_encode($response);
	}

	public function ajaxEditOrderCartNew($Id)
	{
		$new_quan = $this->input->post("newQuantity");
		$new_price = $this->input->post("newPrice");

		 if ((int) $new_quan >= 100000000) {
			showMessage(lang("Very high price, please set smaller", "admin"), lang("Error", "admin"), "r");
			return false;
		}

		$orderproduct = SOrderProductsQuery::create()->findPk($Id);
		$order = SOrdersQuery::create()->filterById($orderproduct->getOrderId())->findOne();

		if ($new_quan) {
			if ($kitId = $orderproduct->getKitId()) {
				$orderproducts = SOrderProductsQuery::create()->filterByKitId($kitId)->filterByOrderId($orderproduct->getOrderId())->find();

				foreach ($orderproducts as $product ) {
					$price_old_total = $product->getPrice() * $product->getQuantity();
					$price_origin_total = $product->getOriginPrice() * $product->getQuantity();
					$product->setQuantity($new_quan);
					$product->save();
					$diff += ($product->getPrice() * $product->getQuantity()) - $price_old_total;
					$diff_origin += ($product->getoriginPrice() * $product->getQuantity()) - $price_origin_total;
				}
			}
			else {
				$price_old_total = $orderproduct->getPrice() * $orderproduct->getQuantity();
				$price_origin_total = $orderproduct->getOriginPrice() * $orderproduct->getQuantity();
				$orderproduct->setQuantity($new_quan);
				$orderproduct->save();
				$diff = ($orderproduct->getPrice() * $orderproduct->getQuantity()) - $price_old_total;
				$diff_origin = ($orderproduct->getOriginPrice() * $orderproduct->getQuantity()) - $price_origin_total;
			}
		}
		else if (!$orderproduct->getKitId()) {
			$price_old_total = $orderproduct->getPrice() * $orderproduct->getQuantity();
			$price_origin_total = $orderproduct->getOriginPrice() * $orderproduct->getQuantity();
			$orderproduct->setPrice($new_price);
			$orderproduct->save();
			$diff = ($orderproduct->getPrice() * $orderproduct->getQuantity()) - $price_old_total;
			$diff_origin = ($orderproduct->getOriginPrice() * $orderproduct->getQuantity()) - $price_origin_total;
		}

		$diff = str_replace(",", ".", $diff);
		$diff_origin = str_replace(",", ".", $diff_origin);
		$DiscountInfo = $order->getDiscountInfo();
		if (($order->getDiscountInfo() == "product") || empty($DiscountInfo)) {
			$this->db->query("update shop_orders set total_price = total_price + '$diff' where id = '" . $orderproduct->getOrderId() . "'");
		}
		else {
			$discount = ($order->getTotalPrice() + $order->getGiftCertPrice()) / $order->getOriginPrice();
			$total_price = $diff_origin * $discount;
			$total_price = str_replace(",", ".", $total_price);
			$this->db->query("update shop_orders set total_price = total_price + '$total_price' where id = '" . $orderproduct->getOrderId() . "'");
		}

		$this->db->query("update shop_orders set origin_price = origin_price + '$diff_origin' where id = '" . $orderproduct->getOrderId() . "'");
		$this->db->query("update shop_orders set discount =  origin_price - COALESCE(gift_cert_price,0) - total_price where id = '" . $orderproduct->getOrderId() . "'");
		$order->reload();
		$order->updateDeliveryPrice();
		$order->save();
		pjax("");

	}

	private function recoutUserOrdersAmount($userId)
	{
		if ($userId) {
			$userOrders = SOrdersQuery::create()->filterByPaid(1)->filterByUserId($userId)->find();

			if (!$userOrders) {
				return false;
			}

			$amount = 0;

			foreach ($userOrders as $order ) {
				$amount += $order->getTotalPrice();
			}

			$user = SUserProfileQuery::create()->filterById((int) $userId)->findOne();

			if ($user) {
				$user->setAmout($amount);
				$user->save();
			}
		}
	}

	public function ajaxEditOrderCart($Id)
	{
		$order = SOrderProductsQuery::create()->filterById((int) $Id)->findOne();

		if ($order->getKitId() != NULL) {
			$ProductsItems = SOrderProductsQuery::create()->filterByOrderId($order->getOrderId())->filterByKitId($order->getKitId())->find();

			if ($this->input->post("newQuantity")) {
				foreach ($ProductsItems as $item ) {
					$item->setQuantity((int) $this->input->post("newQuantity"));
					$item->save();
				}
			}

			$order = SOrdersQuery::create()->findPk($order->getOrderId());
			$order->updateTotalPrice();
			pjax("");
			return;
		}

		$product = SProductsQuery::create()->filterById((int) $_POST["newProductId"])->findOne();
		$variant = SProductVariantsQuery::create()->filterByProductId((int) $_POST["newProductId"])->filterById((int) $_POST["newVariantId"])->findOne();

		if ($order === NULL) {
			return;
		}

		if (($product === NULL) || ($variant === NULL)) {
			if ($this->input->post("newQuantity")) {
				$order->setQuantity((int) $_POST["newQuantity"]);
			}

			if ($this->input->post("newPrice")) {
				$order->setPrice($this->input->post("newPrice"));
			}

			$order->save();
			showMessage(lang("Product updated", "admin"));
		}
		else {
			if ((int) $_POST["newProductId"] != $order->getProductId()) {
				$order->setProductId((int) $_POST["newProductId"]);
				$order->setVariantId((int) $_POST["newVariantId"]);
				$order->setProductName($product->getName());
				$order->setVariantName($variant->getName());
				$order->setPrice($variant->getPrice());
				$order->setQuantity((int) $_POST["newQuantity"]);
			}
			else {
				if (((int) $_POST["newVariantId"] != $order->getVariantId()) && ($_POST["SavePrice"][0] != "yes")) {
					$order->setVariantId((int) $_POST["newVariantId"]);
					$order->setVariantName($variant->getName());
					$order->setPrice($variant->getPrice());
				}
				else if ($_POST["SavePrice"][0] != "yes") {
					$order->setPrice($variant->getPrice());
				}

				if ((int) $_POST["newQuantity"] != $order->getQuantity()) {
					if ((int) $_POST["newQuantity"] < 1) {
						$_POST["newQuantity"] = 1;
					}

					$order->setQuantity((int) $_POST["newQuantity"]);
				}
			}

			$order->save();
			showMessage(lang("Product updated", "admin"));
		}

		$order = SOrdersQuery::create()->findPk($order->getOrderId());
		$order->updateTotalPrice();
		$order->save();
		$order->updateDeliveryPrice();
		$order->save();
		pjax("");
	}

	public function ajaxEditOrderAddToCart($orderId)
	{
		$productId = (int) $this->input->post("newProductId");
		$variantId = (int) $this->input->post("newVariantId");
		$quantity = (int) $this->input->post("newQuantity");
		$order = SOrdersQuery::create()->filterById((int) $orderId)->findOne();

		if ($order != NULL) {
			$product = SProductsQuery::create()->filterById($productId)->findOne();
			$variant = SProductVariantsQuery::create()->filterById($variantId)->findOne();
			$getPrice = $variant->getPrice();

			if (($product != NULL) && ($variant != NULL)) {
				$quantity = ($quantity < 1 ? 1 : $quantity);
				$OrderProducts = new SOrderProducts();
				$OrderProducts->setOrderId((int) $orderId)->setProductId($product->getId())->setVariantId($variant->getId())->setProductName($product->getName())->setVariantName($variant->getName())->setPrice($variant->getPrice())->setOriginPrice($getPrice)->setQuantity($quantity)->save();
				$order->updateOriginPrice();
				$order->save();
				$order->updateTotalPrice();

				if (($order->getDiscountInfo() != "product") && (0 < ($discount = $order->getDiscount()))) {
					$order->setTotalPrice($order->getTotalPrice() - $discount);
				}

				$order->updateDeliveryPrice();
				$order->save();
				showMessage(lang("Item has been added to the order", "admin"));
				pjax("/admin/components/run/shop/orders/edit/" . $order->getId() . "#productsInCart");
			}
			else {
				showMessage(lang("This product does not exist", "admin"));
			}
		}
	}

	public function ajaxGetOrderCart($orderId)
	{
		$criteria = SOrderProductsQuery::create()->orderById(Propel\Runtime\ActiveQuery\Criteria::ASC);
		$model = SOrdersQuery::create()->findPk((int) $orderId);

		foreach ($model->getSOrderProductss($criteria) as $sOrderProduct ) {
			if (0 < $sOrderProduct->getKitId()) {
				if (!isset($kits[$sOrderProduct->getKitId()]["total"])) {
					$kits[$sOrderProduct->getKitId()]["total"] = 0;
				}

				if (!isset($kits[$sOrderProduct->getKitId()]["price"])) {
					$kits[$sOrderProduct->getKitId()]["price"] = 0;
				}

				++$kits[$sOrderProduct->getKitId()]["total"];
				$kits[$sOrderProduct->getKitId()]["price"] = $kits[$sOrderProduct->getKitId()]["price"] + $sOrderProduct->toCurrency();
			}
		}

		$this->render("cart_list", array("model" => SOrdersQuery::create()->filterById($orderId)->findOne(), "kits" => $kits, "deliveryMethods" => SDeliveryMethodsQuery::create()->useI18nQuery(MY_Controller::getCurrentLocale())->orderByName()->endUse()->find(), "paymentMethods" => SPaymentMethodsQuery::create()->useI18nQuery(MY_Controller::getCurrentLocale())->orderByName()->endUse()->find()));
	}

	protected function _count(SOrdersQuery $object)
	{
		$object = clone $object;
		return $object->count();
	}

	public function printChecks($pks = array(1))
	{
		$this->pdf = new TCPDF("P", "mm", "A4", true, "UTF-8", false);
		$this->pdf->setFontSubsetting(false);
		$this->pdf->cms_cache_key = "check" . time();
		$this->pdf->setPDFVersion("1.6");
		$this->pdf->SetFont("dejavusanscondensed", "", 10);
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
		$this->pdf->SetTextColor(0, 0, 0);

		foreach ($pks as $id ) {
			$this->pageNumber = "";
			$model = SOrdersQuery::create()->findPk($id);
			$products = $model->getSOrderProductss();

			if (15 <= $products->count()) {
				$products = array_chunk((array) $products, 15);
				$n = 1;

				foreach ($products as $p ) {
					$this->pageNumber = "/ " . $n;
					$this->createPDFPage($model, $p, true);
					++$n;
				}

				$n = 1;

				foreach ($products as $p ) {
					$this->pageNumber = "/ " . $n;
					$this->createPDFPage($model, $p, true);
					++$n;
				}
			}
			else if (5 < $products->count()) {
				$this->createPDFPage($model, $products, true);
				$this->createPDFPage($model, $products, true);
			}
			else {
				$this->createPDFPage($model, $products, true);
			}
		}

		$this->pdf->Output("Order_No_$id.pdf");
	}

	public function createPDFPage(SOrders $model, $products, $duplicate = false)
	{
		if ($model->getDeliveryMethod()) {
			$freeFrom = SDeliveryMethodsQuery::create()->findPk($model->getDeliveryMethod())->getFreeFrom();
		}
		else {
			$freeFrom = false;
		}

		$deliveryPrice = ($model->getTotalPrice() <= $freeFrom ? $model->getDeliveryPrice() : 0);
		$totalPrice = $model->getTotalPrice() + $deliveryPrice;

		if (0 < $deliveryPrice) {
			$delivery = new SOrderProducts();
			$delivery->setProductName(lang("Delivery", "admin"));
			$delivery->setQuantity(1);
			$delivery->setPrice($deliveryPrice);
			$delivery->setOriginPrice($deliveryPrice);
			$products[] = $delivery;
		}

		if ($model->getSDeliveryMethods() instanceof SDeliveryMethods) {
			$cr = new Propel\Runtime\ActiveQuery\Criteria();
			$cr->add("active", true, Propel\Runtime\ActiveQuery\Criteria::EQUAL);
			$cr->add("shop_delivery_methods.id", $model->getPaymentMethod(), Propel\Runtime\ActiveQuery\Criteria::EQUAL);
			$paymentMethods = $model->getSDeliveryMethods()->getPaymentMethodss($cr);
		}

		$html = $this->render("check", array("model" => $model, "products" => $products, "totalPrice" => $totalPrice, "paymentMethod" => $paymentMethods[0], "pageNumber" => $this->pageNumber), true);

		if ($duplicate === false) {
			$resultHtml = $html . "<p>&nbsp;</p><p><hr></p><p>&nbsp;</p>" . $html;
		}
		else {
			$resultHtml = $html;
		}

		$this->pdf->AddPage();
		$this->pdf->writeHTML($resultHtml, true, false, true, false, "");
	}

	public function createPdf($id)
	{
		$this->printChecks(array($id));
	}

	public function create()
	{
		if (!$this->input->post()) {
			$this->render("create", array("categories" => ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_SINGLE), "deliveryMethods" => SDeliveryMethodsQuery::create()->joinWithI18n($this->defaultLanguage["identif"], Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN)->orderBy("SDeliveryMethodsI18n.Name", Propel\Runtime\ActiveQuery\Criteria::ASC)->find(), "paymentMethods" => SPaymentMethodsQuery::create()->useI18nQuery($this->defaultLanguage["identif"])->orderByName(Propel\Runtime\ActiveQuery\Criteria::ASC)->endUse()->find()));
			exit();
		}

		if (!$this->input->post("shop_orders_products")) {
			showMessage(lang("Items not selected ", "admin"), lang("Error", "admin"), "r");
			exit();
		}

		$this->form_validation->set_rules("shop_orders_products[quantity]", lang("Quantity", "admin"), "numeric|integer");

		if ($this->form_validation->run($this) == false) {
			showMessage(validation_errors(), "", "r");
			exit();
		}

		$shop_orders = $this->input->post("shop_orders");

		if ($shop_orders["user_id"] == NULL) {
			showMessage(lang("User is not selected", "admin"), lang("Error", "admin"), "r");
			exit();
		}

		$this->input->post("action") == "close" ? $action = $this->input->post("action") : $action = "edit";
		$model = new SOrders();
		$model->setUserId($shop_orders["user_id"])->setUserFullName($shop_orders["user_full_name"])->setUserSurname($shop_orders["user_surname"])->setUserEmail($shop_orders["user_email"])->setUserPhone($shop_orders["user_phone"])->setUserDeliverTo($shop_orders["user_delivery_to"])->setTotalPrice($shop_orders["total_price"])->setKey(self::createCode())->setStatus(1);
		$delivery_method = SDeliveryMethodsQuery::create()->findPk((int) $shop_orders["delivery_method"]);

		if ($delivery_method === NULL) {
			$delivery_method = 0;
			$deliveryPrice = 0;
		}
		else {
			$deliveryPrice = $delivery_method->getPrice();
			$delivery_method = $delivery_method->getId();
		}

		$paymentMethod = SPaymentMethodsQuery::create()->findPk((int) $shop_orders["payment_method"]);

		if ($paymentMethod === NULL) {
			$paymentMethod = 0;
		}
		else {
			$paymentMethod = $paymentMethod->getId();
		}

		$model->setDeliveryMethod($delivery_method)->setDeliveryPrice($deliveryPrice)->setPaymentMethod($paymentMethod)->setDateCreated(time())->setDateUpdated(time())->save();
		$shopOrderProducts = $this->input->post("shop_orders_products");
		$totalProducts = count($shopOrderProducts["product_id"]);
		$orderId = $model->getId();
		$orderproducts = array();
		$orderproducts["order_id"] = $orderId;
		$origPrice = 0;
		$price = 0;
		$i = 0;

		for ($i = 0; $i < $totalProducts; $i++) {
			if ($shopOrderProducts["variant_name"][$i] == "-") {
				$shopOrderProducts["variant_name"][$i] = "";
			}

			$product = $this->db->where("id", $shopOrderProducts["variant_id"][$i])->get("shop_product_variants")->row();
			$data = array(
						"order_id" => $orderId, 
						"product_id" => $shopOrderProducts["product_id"][$i], 
						"product_name" => $shopOrderProducts["product_name"][$i], 
						"variant_id" => $shopOrderProducts["variant_id"][$i], 
						"variant_name" => $shopOrderProducts["variant_name"][$i], 
						"price" => $shopOrderProducts["price"][$i], 
						"quantity" => $shopOrderProducts["quantity"][$i], 
						"origin_price" => $product->price
						);
			$orderproducts["products"][] = $shopOrderProducts["product_id"][$i];
			$this->db->insert("shop_orders_products", $data);
			$origPrice += round($product->price, 2) * $shopOrderProducts["quantity"][$i];
			$price += $shopOrderProducts["price"][$i] * $shopOrderProducts["quantity"][$i];
		}

		$origPrice = strtr($origPrice, array("," => "."));
		$price = strtr($price, array("," => "."));
		$option = array("price" => $origPrice, "userId" => $shop_orders["user_id"], "ignoreCart" => 1, "reBuild" => 1);
		$discount = $this->load->module("mod_discount/discount_api")->getDiscount($option, true);
		$subtotal = $origPrice - $price;

		if ($subtotal < $discount["sum_discount_no_product"]) {
			$model->setOriginPrice($origPrice)->setTotalPrice($origPrice - $discount["sum_discount_no_product"])->setDiscountInfo("user")->setDiscount(strtr($discount["sum_discount_no_product"], array("," => ".")))->save();
		}
		else if ($discount["sum_discount_no_product"] <= $subtotal) {
			$model->setOriginPrice($origPrice)->setTotalPrice($price)->setDiscountInfo("product")->setDiscount(strtr($subtotal, array("," => ".")))->save();
		}

		if ($Gift = $this->input->post("gift")) {
			$GiftArray = ($orderarray["total_price"] ? $orderarray["total_price"] : $price);
			$gift = json_decode($this->load->module("mod_discount/discount_api")->getGiftCertificate($Gift, $GiftArray));

			if (!$gift->error) {
				$model->setGiftCertKey($gift->key)->setTotalPrice($GiftArray - $gift->val_orig)->setOriginPrice($origPrice)->setGiftCertPrice($gift->val_orig)->save();
				$this->db->where("key", $gift->key)->update("mod_shop_discounts", array("active" => 0));
			}
		}

		$orderStatus = new SOrderStatusHistory();
		$orderStatus->setOrderId($orderId)->setStatusId(1)->setUserId($shop_orders["user_id"])->setDateCreated(time())->setComment("")->save();

		if (!$orderStatus->getId()) {
			showMessage(lang("Order bad ", "admin"), lang("Error", "admin"), "r");
		}

		CMSFactory\Events::create()->registerEvent(array("order_products" => $orderproducts), "ShopAdminOrder:create");
		CMSFactory\Events::runFactory();
		$checkLink = site_url() . "admin/components/run/shop/orders/createPdf/" . $model->getId();
		$CurrencySymbol = Currency\Currency::create()->getSymbol();
		$UserInfo = array("userName" => $model->getUserFullName(), "userEmail" => $model->getUserEmail(), "userPhone" => $model->getUserPhone(), "userDeliver" => $model->getUserDeliverTo(), "orderLink" => shop_url("cart/view/" . $model->getKey()), "products" => $this->createProducsInfoTable($model), "deliveryPrice" => $model->getDeliveryPrice() . " " . $CurrencySymbol, "checkLink" => $checkLink, "totalPrice" => $model->getTotalPrice() . " " . $CurrencySymbol);
		cmsemail\email::getInstance()->sendEmail($model->getUserEmail(), "make_order", $UserInfo);
		$OrderHistory = $this->db->order_by("id", "desc")->get("shop_orders")->row()->id;
		$this->lib_admin->log(lang("Order is created", "admin") . ". Id: " . $OrderHistory);
		showMessage(lang("Order was successfully created", "admin"));

		switch ($action) {
		case "edit":
			pjax("/admin/components/run/shop/orders/edit/" . $model->getId());
		case "close":
			pjax("/admin/components/run/shop/orders");
		}

	}

	private function getTotalRow()
	{
		$connection = Propel\Runtime\Propel::getConnection("Shop");
		$statement = $connection->prepare("SELECT FOUND_ROWS() as `number`");
		$statement->execute();
		$resultset = $statement->fetchAll();
		return $resultset[0]["number"];
	}

	public function ajaxGetProductsInCategory()	{
		$categoryId = $this->input->post("categoryId");
		$currentCategoryFullPath = $this->db->select("full_path")->where("id", $categoryId)->get("shop_category")->row_array();
		$query = $this->db->select("id")->like("full_path", $currentCategoryFullPath["full_path"])->get("shop_category")->result_array();
		$categoriesIds = array();

		foreach ($query as $q ) {
			$categoriesIds[] .= $q["id"];
		}

		$products = $this->db->select("shop_products.id, shop_products_i18n.name")->from("shop_products")->join("shop_products_i18n", "shop_products.id = shop_products_i18n.id")->where("shop_products_i18n.locale", MY_Controller::getCurrentLocale())->where_in("shop_products.category_id", $categoriesIds)->get()->result_array();
		echo json_encode($products);
	}

	public function ajaxGetProductVariants()
	{
		$productId = $this->input->post("productId");
		$product = $this->db->where("id", $productId)->get("shop_products")->row();
		$categoryId = $product->category_id;
		$BrandId = $product->brand_id;
		$productVariants = $this->db->select("shop_product_variants.id, shop_product_variants_i18n.name, shop_product_variants.price,shop_currencies.symbol, shop_product_variants.stock, shop_product_variants.number")->from("shop_products")->join("shop_product_variants", "shop_products.id = shop_product_variants.product_id")->join("shop_product_variants_i18n", "shop_product_variants.id = shop_product_variants_i18n.id")->join("shop_currencies", "shop_product_variants.currency = shop_currencies.id")->where("shop_product_variants_i18n.locale", MY_Controller::getCurrentLocale())->where("shop_product_variants.product_id", $productId)->get()->result_array();

		foreach ($productVariants as $key => $variants ) {
			$productVariantsData = array("product_id" => $productId, "category_id" => $categoryId, "brand_id" => $BrandId, "vid" => $variants["id"], "id" => $productId);

			if (count($this->db->where("name", "mod_discount")->get("components")->result_array()) != 0) {
				mod_discount\discount_product::create()->getProductDiscount($productVariantsData);
			}

			if ($discount = CMSFactory\assetManager::create()->discount) {
				$price = $discount["price"];
				$discount_value = $discount["discount_value"];
				$subsumm = (double) $price - (double) $discount_value;
				$subsumm < 0 ? $subprice = 1 : $subprice = $subsumm;
				$productVariants[$key]["price"] = $subprice;
				$productVariants[$key]["origPrice"] = $price;
				$productVariants[$key]["numDiscount"] = $discount_value;
			}
			else {
				$productVariants[$key]["origPrice"] = $price;
			}
		}

		echo json_encode($productVariants);
	}

	public function getImageName()
	{
		$variantId = $this->input->post("variantId");
		$query = $this->db->select("mainImage")->where("id", $variantId)->get("shop_product_variants")->row_array();
		echo $query["mainImage"];
	}

	public function autoComplite()
	{
		$Limit = $this->input->get("limit");
		$Term = $this->input->get("term");
		$model = SUserProfileQuery::create();
		$model = $model->where("SUserProfile.Name LIKE \"%" . $Term . "%\"")->_or()->where("SUserProfile.UserEmail LIKE \"%" . $Term . "%\"")->_or()->where("SUserProfile.Id LIKE \"%" . $Term . "%\"")->limit($Limit)->find();

		foreach ($model as $val ) {
			$response[] = array("value" => $val->getId() . " - " . $val->getName() . " - " . $val->getUserEmail(), "id" => $val->getId(), "name" => $val->getName(), "email" => $val->getUserEmail(), "phone" => $val->getPhone(), "address" => $val->getAddress());
		}

		echo json_encode($response);
	}

	public function createNewUser()
	{
		$this->input->post("");
		$data = array("name" => $this->input->post("name"), "password" => ShopCore::$ci->dx_auth->_gen_pass(), "email" => $this->input->post("email"), "phone" => $this->input->post("phone"), "address" => $this->input->post("address"));

		if (!ShopCore::$ci->dx_auth->is_email_available($data["email"])) {
			echo "email";
		}
		else if (ShopCore::$ci->dx_auth->register($data["name"], $data["password"], $data["email"], $data["address"], "", $data["phone"], $false)) {
			echo $this->getLastUserInfo();
		}
		else {
			echo "false";
		}
	}

	public function ajaxGetUserDiscount()
	{
		$userId = $this->input->post("userId");

		if ($userId != NULL) {
			$query = $this->db->select("discount")->from("users")->where("id", $userId)->get()->row_array();
		}

		if ($query != NULL) {
			echo $query["discount"];
		}
	}

	public function getPaymentsMethods($deliveryId)
	{
		$paymentMethods = ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($deliveryId)->find();
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsId[] = $paymentMethod->getPaymentMethodId();
        }
        $paymentMethod = SPaymentMethodsQuery::create()->filterByActive(true)->where('SPaymentMethods.Id IN ?', $paymentMethodsId)->orderByPosition()->find();

        $jsonData = array();
        foreach ($paymentMethod->getData() as $pm) {
            $jsonData[] = array(
                'id' => $pm->getId(),
                'name' => $pm->getName()
            );
        }

        echo json_encode($jsonData);
	}


	public function checkGiftCert($key)
	{
		$date = time();
		$query = $this->db->where("key", $key)->where("espdate >", $date)->where("active", 1)->get("shop_gifts")->row_array();
		echo json_encode($query);
	}

	public static function createCode($charsCount = 3, $digitsCount = 7)
	{
		$chars = array("q", "w", "e", "r", "t", "y", "u", "i", "p", "a", "s", "d", "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m");

		if (sizeof($chars) < $charsCount) {
			$charsCount = sizeof($chars);
		}

		$result = array();

		if (0 < $charsCount) {
			$CharArray = array_rand($chars, $charsCount);

			foreach ($CharArray as $key => $val ) {
				array_push($result, $chars[$val]);
			}
		}


		$i = 0;

		while ($i < $digitsCount) {
			array_push($result, rand(0, 9));
			++$i;
		}

		shuffle($result);
		$result = implode("", $result);

		if (0 < sizeof(SOrdersQuery::create()->filterByKey($result)->select(array("Key"))->limit(1)->find())) {
			self::createCode($charsCount, $digitsCount);
		}

		return $result;
	}

	public function getLastUserInfo()
	{
		$response = $this->db->order_by("id", "desc")->get("users")->row_array();

		if ($response) {
			echo json_encode($response);
		}
		else {
			echo "false";
		}
	}

	public function createProducsInfoTable(SOrders $order)
	{
		$CurrencySymbol = Currency\Currency::create()->getSymbol();
		$CssStyle = " style='border: 1px solid #e5e5e5; padding: 5px' ";
		$HtmlTable = "<table cellspacing='0' style='min-width: 400px; border: 1px solid #eaeaea;'><thead>   <th$CssStyle>" . lang("Product", "admin") . "</th>   <th$CssStyle>" . lang("Option", "admin") . "</th>   <th$CssStyle>" . lang("Quantity", "admin") . "</th>   <th$CssStyle>" . lang("Price", "admin") . "</th>   <th$CssStyle>" . lang("Total", "admin") . "</th></thead><tbody>";
		$orderproducts = SOrderProductsQuery::create()->filterByOrderId($order->getId())->find();
		$total = 0;

		foreach ($orderproducts as $item ) {
			$getPrice = $item->getPrice() * $item->getQuantity();
			$total += $getPrice;
			$HtmlTable .= "<tr><td$CssStyle>$item->getProductName()</td><td$CssStyle>$item->getVariantName()</td><td$CssStyle>$item->getQuantity()</td><td$CssStyle>$item->getPrice() $CurrencySymbol</td><td$CssStyle>$getPrice $CurrencySymbol</td></tr>";
		}

		if (1 < ($discount = $order->getDiscount())) {
			$total -= $discount;
			$HtmlTable .= "<tr><td colspan='4'$CssStyle>" . lang("Discount", "admin") . "</td><td$CssStyle>$discount $CurrencySymbol</td></tr>";
		}

		$HtmlTable .= "<tr><td colspan='4'$CssStyle>" . lang("Total price", "admin") . "</td><td$CssStyle>$total $CurrencySymbol</td></tr>";
		$HtmlTable .= "</tbody></table>";
		return $HtmlTable;
	}
}


?>
