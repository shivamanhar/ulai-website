<?php

class ShopAdminCallbacks extends ShopAdminController
{
	protected $perPage = 14;
	public $defaultLanguage;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
	}

	public function index($status = NULL, $offset = 0, $orderField = "", $orderCriteria = "")
	{
		$offset = $_GET["per_page"];
		$model = SCallbacksQuery::create()->joinSCallbackStatuses(NULL, "left join")->joinSCallbackThemes(NULL, "left join");

		if (isset(ShopCore::$_GET["filterID"]) && (0 < ShopCore::$_GET["filterID"])) {
			$model = $model->filterById((int) ShopCore::$_GET["filterID"]);
		}

		if (!empty(ShopCore::$_GET["user_name"])) {
			$user_name = ShopCore::$_GET["user_name"];

			if (!strpos($user_name, "%")) {
				$user_name = "%" . $user_name . "%";
			}

			$model->condition("name", "SCallbacks.Name LIKE ?", $user_name);
			$model->where(array("name"), Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR);
		}

		if (!empty(ShopCore::$_GET["phone"])) {
			$phone = ShopCore::$_GET["phone"];

			if (!strpos($phone, "%")) {
				$phone = "%" . $phone . "%";
			}

			$model->condition("phone", "SCallbacks.Phone LIKE ?", $phone);
			$model->where(array("phone"), Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR);
		}

		if (isset(ShopCore::$_GET["ThemeId"]) && (0 < ShopCore::$_GET["ThemeId"])) {
			$model = $model->filterByThemeId((int) ShopCore::$_GET["ThemeId"]);
		}

		if (ShopCore::$_GET["StatusId"] && (0 < ShopCore::$_GET["StatusId"])) {
			$model = $model->filterByStatusId((int) ShopCore::$_GET["StatusId"]);
		}

		if (ShopCore::$_GET["created_from"]) {
			$model = $model->where("FROM_UNIXTIME(SCallbacks.Date, '%Y-%m-%d') >= ?", date("Y-m-d", strtotime(ShopCore::$_GET["created_from"])));
		}

		if (ShopCore::$_GET["created_to"]) {
			$model = $model->where("FROM_UNIXTIME(SCallbacks.Date, '%Y-%m-%d') <= ?", date("Y-m-d", strtotime(ShopCore::$_GET["created_to"])));
		}

		if (($orderCriteria !== "") && (method_exists($model, "filterBy" . $orderField) || ($orderField == "SCallbackStatuses.Text") || ($orderField == "SCallbackThemes.Text"))) {

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
		else {
			$model->orderById(Propel\Runtime\ActiveQuery\Criteria::DESC);
		}

		$totalCallbacks = ($model);
		$model = $model->limit($this->perPage)->offset((int) $offset)->find();
		$callbackStatuses = SCallbackStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::RIGHT_JOIN)->where("SCallbackStatusesI18n.Locale = \"" . MY_Controller::defaultLocale() . "\"")->orderBy("IsDefault", Propel\Runtime\ActiveQuery\Criteria::DESC)->orderById()->find();
		$callbackThemes = SCallbackThemesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find();
		$this->load->library("pagination");
		$config["base_url"] = $this->createUrl("callbacks/index/?") . http_build_query(ShopCore::$_GET);
		$config["container"] = "shopAdminPage";
		$config["page_query_string"] = true;
		$config["total_rows"] = $totalCallbacks;
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
		$config["last_tag_open"] = "<li>";
		$config["last_tag_close"] = "</li>";
		$config["first_tag_open"] = "<li>";
		$config["first_tag_close"] = "</li>";
		$this->pagination->num_links = 6;
		$config["suffix"] = ($orderField != "" ? $orderField . "/" . $orderCriteria : "");
		$this->pagination->initialize($config);
		$this->render("list", array("model" => $model, "pagination" => $this->pagination->create_links_ajax(), "totalCallbacks" => $totalCallbacks, "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "callbackStatuses" => $callbackStatuses, "callbackThemes" => $callbackThemes));
	}

	public function update($callbackId = NULL)
	{
		$model = SCallbacksQuery::create()->findPk((int) $callbackId);

		if ($model === NULL) {
			$this->error404(lang("Error", "admin"));
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), lang("Error"), "r");
			}
			else {
				$model->fromArray($_POST);

				if ($model->getStatusId() !== $_POST["StatusId"]) {
					$model->setUserId($this->dx_auth->get_user_id());
				}

				$model->save();
				$this->lib_admin->log(lang("Callback edited", "admin") . ". Id: " . $callbackId);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "close") {
					$redirect_url = "/admin/components/run/shop/callbacks";
				}

				if ($_POST["action"] == "edit") {
					$redirect_url = "/admin/components/run/shop/callbacks/update/" . $model->getId();
				}

				pjax($redirect_url);
			}
		}
		else {
			$statuses = SCallbackStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)->orderByIsDefault(Propel\Runtime\ActiveQuery\Criteria::DESC)->orderById()->find();
			$themes = SCallbackThemesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)->orderByPosition()->orderById()->find();
			$this->render("edit", array("model" => $model, "statuses" => $statuses, "themes" => $themes));
		}
	}

	public function statuses()
	{
		$model = SCallbackStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderBy("IsDefault", Propel\Runtime\ActiveQuery\Criteria::DESC)->orderById(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$this->render("status_list", array("model" => $model, "locale" => MY_Controller::defaultLocale()));
	}

	public function createStatus()
	{
		$model = new SCallbackStatuses();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				if (!$_POST["IsDefault"]) {
					$_POST["IsDefault"] = false;
				}

				$model->fromArray($_POST);
				$model->save();
				$shop_callbacks_statuses = $this->db->order_by("id", "desc")->get("shop_callbacks_statuses")->row()->id;
				$this->lib_admin->log(lang("Status callback created", "admin") . ". Id: " . $shop_callbacks_statuses);
				showMessage(lang("Position created", "admin"));

				if ($_POST["action"] == "new") {
					$redirect_url = "/admin/components/run/shop/callbacks/updateStatus/" . $model->getId();
				}

				if ($_POST["action"] == "exit") {
					$redirect_url = "/admin/components/run/shop/callbacks/statuses";
				}

				pjax($redirect_url);
			}
		}
		else {
			$this->render("create_status", array("model" => $model, "locale" => $this->defaultLanguage["identif"]));
		}
	}

	public function updateStatus($statusId = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? MY_Controller::defaultLocale() : $locale);
		$model = SCallbackStatusesQuery::create()->findPk((int) $statusId);

		if ($model === NULL) {
			showMessage(lang("Such status does not exist", "admin"), "404", "r");
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors());
			}
			else {
				if (!$_POST["IsDefault"]) {
					unset($_POST["IsDefault"]);
				}

				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Status callback edited", "admin") . ". Id: " . $statusId);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "close") {
					$redirect_url = "/admin/components/run/shop/callbacks/statuses";
				}

				if ($_POST["action"] == "edit") {
					$redirect_url = "/admin/components/run/shop/callbacks/updateStatus/" . $model->getId() . "/" . $locale;
				}

				pjax($redirect_url);
			}
		}
		else {
			$model->setLocale($locale);
			$this->render("edit_status", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale));
		}
	}

	public function setDefaultStatus()
	{
		if ($_POST["id"] && is_numeric($_POST["id"])) {
			$model = SCallbackStatusesQuery::create()->findPk($_POST["id"]);

			if ($model) {
				if ($model->getIsDefault() == false) {
					showMessage(lang("Default status was changed", "admin"));
				}

				$model->setIsDefault(true);
				$model->save();
				$message = lang("Callback default status changed. New default status ID:", "admin") . " " . $model->getId();
				$this->lib_admin->log($message);
			}
		}
	}

	public function changeStatus()
	{
		$callbackId = (int) $_POST["CallbackId"];
		$statusId = (int) $_POST["StatusId"];
		$model = SCallbacksQuery::create()->findPk($callbackId);
		$newStatusId = SCallbackStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->findPk((int) $statusId);

		if (!empty($newStatusId)) {
			if ($model !== NULL) {
				$model->setStatusId($statusId);
				$model->setUserId($this->dx_auth->get_user_id());
				$model->save();
				$message = lang("Callback status changed to", "admin") . " " . $newStatusId->getText() . ". " . lang("Id:", "admin") . " " . $callbackId;
				$this->lib_admin->log($message);
				showMessage(lang("Callback's status was changed", "admin"));
				pjax("/admin/components/run/shop/callbacks#callbacks_" . $_POST["StatusId"]);
			}
		}
	}

	public function reorderThemes()
	{
		if (0 < sizeof($_POST["positions"])) {
			foreach ($_POST["positions"] as $pos => $id ) {
				SCallbackThemesQuery::create()->filterById($id)->update(array("Position" => (int) $pos));
			}

			showMessage(lang("Positions saved successfully", "admin"));
		}
	}

	public function changeTheme()
	{
		$callbackId = (int) $_POST["CallbackId"];
		$themeId = (int) $_POST["ThemeId"];
		$model = SCallbacksQuery::create()->findPk($callbackId);

		if ($model !== NULL) {
			$model->setThemeId($themeId);
			$model->setUserId($this->dx_auth->get_user_id());
			$model->save();
			$theme = SCallbackThemesI18nQuery::create()->filterById($themeId)->filterByLocale(MY_Controller::defaultLocale())->findOne();
			$message = lang("Callback theme changed to", "admin") . " " . ($theme ? $theme->getText() : lang("Does not have", "admin")) . ". " . lang("Id:", "admin") . " " . $callbackId;
			$this->lib_admin->log($message);
			showMessage(lang("Callback theme is changed", "admin"));
		}
	}

	public function deleteCallback()
	{
		$id = $_POST["id"];

		if (is_numeric($id)) {
			$model = SCallbacksQuery::create()->findPk($id)->delete();
			$this->lib_admin->log(lang("Callback was removed", "admin") . ". Id: " . $id);
			showMessage(lang("Callback was removed", "admin"));
		}

		if (is_array($id)) {
			$model = SCallbacksQuery::create()->findBy("id", $id)->delete();
			$this->lib_admin->log(lang("Callback(s) was removed", "admin") . ". Id: " . implode(", ", $id));
			showMessage(lang("Callback(s) was removed", "admin"));
		}

		pjax("/admin/components/run/shop/callbacks");
	}

	public function deleteStatus()
	{
		$id = (int) $_POST["id"];
		$model = SCallbackStatusesQuery::create()->findPk($id);
		$DelStatus = $this->db->where("is_default", "1")->get("shop_callbacks_statuses")->row()->id;

		if ($model !== NULL) {
			if ($model->getIsDefault() == true) {
				showMessage(lang("Unable to remove default status", "admin"), lang("Error", "admin"), "r");
				exit();
			}

			$this->db->where("status_id", $model->getId())->update("shop_callbacks", array("status_id" => $DelStatus));
			$model->delete();
			SCallbackStatusesI18nQuery::create()->findById($id)->delete();
			$this->lib_admin->log(lang("Status callback was removed", "admin") . ". Id: " . $id);
			showMessage(lang("Status was removed", "admin"));
			pjax("/admin/components/run/shop/callbacks/statuses");
		}
	}

	public function themes()
	{
		$model = SCallbackThemesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->orderById(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$this->render("themes_list", array("model" => $model, "locale" => MY_Controller::defaultLocale()));
	}

	public function createTheme()
	{
		$model = new SCallbackThemes();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors());
			}
			else {
				$locale = (array_key_exists("Locale", $_POST) ? $_POST["Locale"] : $this->defaultLanguage["identif"]);
				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->save();
				$ShopOrder = $this->db->order_by("id", "desc")->get("shop_orders")->row()->id;
				$this->lib_admin->log(lang("Topic callbacks created", "admin") . ". Id: " . $ShopOrder);
				showMessage(lang("Topic started", "admin"));

				if ($_POST["action"] == "close") {
					$redirect_url = "/admin/components/run/shop/callbacks/themes";
				}

				if ($_POST["action"] == "edit") {
					$redirect_url = "/admin/components/run/shop/callbacks/updateTheme/" . $model->getId();
				}

				pjax($redirect_url);
			}
		}
		else {
			$this->render("create_theme", array("model" => $model, "locale" => $this->defaultLanguage["identif"]));
		}
	}

	public function updateTheme($themeId = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SCallbackThemesQuery::create()->findPk((int) $themeId);

		if ($model === NULL) {
			$this->error404(lang("Error", "admin"));
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors());
			}
			else {
				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Topic callbacks edited", "admin") . ". Id: " . $themeId);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "close") {
					$redirect_url = "/admin/components/run/shop/callbacks/themes";
				}

				if ($_POST["action"] == "edit") {
					$redirect_url = "/admin/components/run/shop/callbacks/updateTheme/" . $model->getId() . "/" . $locale;
				}

				pjax($redirect_url);
			}
		}
		else {
			$model->setLocale($locale);
			$this->render("edit_theme", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale));
		}
	}

	public function deleteTheme()
	{
		$id = (int) $_POST["id"];
		$model = SCallbackThemesQuery::create()->findPk($id);

		if ($model !== NULL) {
			$this->db->where("status_id", $model->getId())->update("shop_callbacks", array("theme_id" => "0"));
			$model->delete();
			$this->lib_admin->log(lang("Topic callbacks deleted", "admin") . ". Id: " . $id);
			showMessage(lang("Topic deleted", "admin"));
			pjax("/admin/components/run/shop/callbacks/themes");
		}
	}

	public function search($offset = 0, $orderField = "", $orderCriteria = "")
	{
		$model = SCallbacksQuery::create()->joinSCallbackStatuses(NULL, "left join")->joinSCallbackThemes(NULL, "left join");

		if (ShopCore::$_GET["status_id"] != NULL) {
			$model = $model->filterByStatusId((int) ShopCore::$_GET["status_id"]);
		}

		if (ShopCore::$_GET["callback_id"]) {
			$model = $model->filterById((int) ShopCore::$_GET["callback_id"]);
		}

		if (ShopCore::$_GET["phone"]) {
			$model = $model->where("SCallbacks.Phone LIKE \"%" . encode(ShopCore::$_GET["phone"]) . "%\"");
		}

		if (ShopCore::$_GET["name"]) {
			$model = $model->where("SCallbacks.Name LIKE \"%" . encode(ShopCore::$_GET["name"]) . "%\"");
		}

		if (ShopCore::$_GET["date"]) {
			$model = $model->where("FROM_UNIXTIME(SCallbacks.Date, '%Y-%m-%d') = ?", ShopCore::$_GET["date"]);
		}

		if (($orderCriteria !== "") && (method_exists($model, "filterBy" . $orderField) || ($orderField == "SCallbackStatuses.Text") || ($orderField == "SCallbackThemes.Text"))) {

		switch ($orderCriteria) {
			case "ASC":
				$model = $model->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::ASC);
				$nextOrderCriteria = "DESC";
			case "DESC":
				$model = $model->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::DESC);
				$nextOrderCriteria = "ASC";
			}
		}
		else {
			$model->orderById("desc");
		}

		if (!$this["status"]) {
			ShopCore::$_GET["status"] = SCallbackStatusesQuery::create()->filterByIsDefault(true)->findOne()->getId();
		}

		if (($status != NULL) && (0 < $status)) {
			ShopCore::$_GET["status"] = (int) $status;
		}

		$totalCallbacks = $this->_count($model);
		$model = $model->limit($this->perPage)->offset((int) $offset)->find();
		$getData = ShopCore::$_GET;
		unset($getData["per_page"], $getData["status"]);
		$queryString = "?" . urlencode(http_build_query($getData));
		$callbackStatuses = SCallbackStatusesQuery::create()->orderById()->find();
		$this->load->library("pagination");
		$config["base_url"] = $this->createUrl("callbacks/search/");
		$config["container"] = "shopAdminPage";
		$config["uri_segment"] = 7;
		$config["total_rows"] = $totalCallbacks;
		$config["per_page"] = $this->perPage;
		$this->pagination->num_links = 6;
		$config["suffix"] = ($orderField != "" ? $orderField . "/" . $orderCriteria . $queryString : $queryString);
		$this->pagination->initialize($config);
		ShopCore::$_GET["status"] = -1;
		$this->render("list", array("model" => $model, "pagination" => $this->pagination->create_links_ajax(), "totalCallbacks" => $totalCallbacks, "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "callbackStatuses" => $callbackStatuses));
	}

	protected function _count(SCallbacksQuery $object)
	{
		$object = clone $object;
		return $object->count();
	}
}


?>
