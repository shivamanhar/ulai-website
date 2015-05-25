<?php

class ShopAdminOrderstatuses extends ShopAdminController
{
	public $defaultLanguage;
	public $defaultBackgroundColor = "#7d7c7d";
	public $defaultFontColor = "#ffffff";

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
	}

	public function index()
	{
		$model = SOrderStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find();
		$statusesInUse = array();

		foreach (SOrdersQuery::create()->find() as $order ) {
			$statusesInUse[$order->getStatus()] = $order->getStatus();
		}

		$this->render("list", array("statusesInUse" => $statusesInUse, "model" => $model, "locale" => $this->defaultLanguage["identif"]));
	}

	public function create()
	{
		$locale = (array_key_exists("Locale", $_POST) ? $_POST["Locale"] : $this->defaultLanguage["identif"]);
		$model = new SOrderStatuses();

		if ($_POST) {
			$this->createDBFields();
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors());
			}
			else {
				$_POST["Color"] = ($_POST["Color"] ? $_POST["Color"] : $this->defaultBackgroundColor);
				$_POST["Fontcolor"] = ($_POST["Fontcolor"] ? $_POST["Fontcolor"] : $this->defaultFontColor);
				$model->fromArray($_POST);
				$Position = SOrderStatusesQuery::create()->select("Position")->where("SOrderStatuses.Id != 2")->orderByPosition("Desc")->limit(1)->find();
				$model->setPosition($Position[0] + 1);
				$model->save();
				$shop_order_statuses = $this->db->order_by("id", "desc")->get("shop_order_statuses")->row()->id;
				$this->lib_admin->log(lang("Order status established", "admin") . ". Id: " . $shop_order_statuses);
				showMessage(lang("Order status created", "admin"));
				$_POST["action"] ? $action = $_POST["action"] : $action = "edit";

				if ($action == "close") {
					pjax("/admin/components/run/shop/orderstatuses/index");
				}

				if ($action == "edit") {
					pjax("/admin/components/run/shop/orderstatuses/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->template->registerCssFile("/templates/administrator/js/colorpicker/css/colorpicker.css", "after");
			$this->template->registerJsFile("/templates/administrator/js/colorpicker/js/colorpicker.js", "after");
			$this->render("create", array("model" => $model, "locale" => $this->defaultLanguage["identif"]));
		}
	}

	public function edit($id = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SOrderStatusesQuery::create()->findPk((int) $id);

		if ($model === NULL) {
			$this->error404(lang("Order Status not found", "admin"));
		}

		if ($_POST) {
			$this->createDBFields();
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors());
			}
			else {
				$_POST["Active"] = (bool) $_POST["Active"];
				$_POST["Locale"] = $locale;
				$_POST["Color"] = ($_POST["Color"] ? $_POST["Color"] : $this->defaultBackgroundColor);
				$_POST["Fontcolor"] = ($_POST["Fontcolor"] ? $_POST["Fontcolor"] : $this->defaultFontColor);
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Order status edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes have been saved", "admin"));
				$_POST["action"] ? $action = $_POST["action"] : $action = "edit";

				if ($action == "close") {
					pjax("/admin/components/run/shop/orderstatuses/index");
				}
			}
		}
		else {
			$model->setLocale($locale);
			$this->template->registerCssFile("templates/administrator/js/colorpicker/css/colorpicker.css", "after");
			$this->template->registerJsFile("templates/administrator/js/colorpicker/js/colorpicker.js", "after");
			$this->render("edit", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale));
		}
	}

	public function delete()
	{
		$id = (int) $_POST["id"];
		$moveOrDelete = (int) $_POST["moveOrDelete"];
		$moveTo = ($_POST["moveTo"][0] ? (int) $_POST["moveTo"][0] : (int) $_POST["CategoryId"]);

		if (($id != 1) && ($id != 2)) {
			$model = SOrderStatusesQuery::create()->findPk($id);

			if ($model) {
				$orders = SOrdersQuery::create()->filterByStatus($id)->find();

				if ($moveOrDelete === 2) {
					foreach ($orders as $order ) {
						$order->delete();
					}

					$model->delete();
					$this->lib_admin->log(lang("Status and related orders removed", "admin") . ". Id: " . $id);
					showMessage(lang("Status and related orders removed", "admin"));
				}
				else if ($moveOrDelete === 1) {
					foreach ($orders as $order ) {
						$order->setStatus($moveTo);
						$order->save();
						$this->db->where("order_id", $order->getId())->update("shop_orders_status_history", array("status_id" => $moveTo));
					}

					$model->delete();
					$this->lib_admin->log(lang("Orders status was removed", "admin") . ". Id: " . $id);
					showMessage(lang("Status removed", "admin"));
				}

				if ($moveOrDelete === 0) {
					$model->delete();
					$this->lib_admin->log(lang("Orders status was removed", "admin") . ". Id: " . $id);
					showMessage(lang("Status removed", "admin"));
				}

				pjax("/admin/components/run/shop/orderstatuses");
			}
			else {
				showMessage(lang("Such status does not exist", "admin"), "", "r");
			}
		}
		else {
			showMessage(lang("Unable to remove the base status", "admin"));
		}
	}

	public function ajaxDeleteWindow($statusId)
	{
		$orders = SOrdersQuery::create()->findByStatus($statusId);
		$this->render("_deleteWindow", array("statuses" => SOrderStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->find(), "statusId" => $statusId, "orders" => $orders));
	}

	public function savePositions()
	{
		$positions = $_POST["positions"];

		if (sizeof($positions) == 0) {
			return false;
		}

		foreach ($positions as $key => $val ) {
			$query = "UPDATE `shop_order_statuses` SET `position`=" . $key . " WHERE `id`=" . (int) $val . "; ";
			$this->db->query($query);
		}

		showMessage(lang("Positions saved successfully", "admin"));
	}

	private function createDBFields()
	{
		if (!$this->db->field_exists("color", "shop_order_statuses") && !$this->db->field_exists("fontcolor", "shop_order_statuses")) {
			$this->load->dbforge();
			$fields = array(
				"color"     => array("type" => "VARCHAR", "constraint" => "255"),
				"fontcolor" => array("type" => "VARCHAR", "constraint" => "255")
				);
			$this->dbforge->add_column("shop_order_statuses", $fields);
		}
	}
}


?>
