<?php

class ShopAdminNotificationstatuses extends ShopAdminController
{
	public $defaultLanguage;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
	}

	public function index()
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SNotificationStatusesQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find();
		$statusesInUse = array();

		foreach (SNotificationsQuery::create()->find() as $notification ) {
			$statusesInUse[$notification->getStatus()] = $notification->getStatus();
		}

		$this->render("list", array("statusesInUse" => $statusesInUse, "model" => $model));
	}

	public function create()
	{
		$model = new SNotificationStatuses();

		if ($_POST) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$model->fromArray($_POST);
				$posModel = SNotificationStatusesQuery::create()->select("Position")->orderByPosition("Desc")->limit(1)->find();
				$model->setPosition($posModel[0] + 1);
				$model->save();
				$NotificationStatus = $this->db->order_by("id", "desc")->get("shop_notification_statuses")->row()->id;
				$this->lib_admin->log(lang("Pendings status was created", "admin") . ". Id: " . $NotificationStatus);
				showMessage(lang("Pendings status was created", "admin"));

				if ($_POST["action"] == "back") {
					pjax("/admin/components/run/shop/notificationstatuses");
				}
				else {
					pjax("/admin/components/run/shop/notificationstatuses/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->render("create", array("model" => $model));
		}
	}

	public function edit($id = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? MY_Controller::defaultLocale() : $locale);
		$model = SNotificationStatusesQuery::create()->joinWithI18n($locale)->findPk((int) $id);

		if ($model === NULL) {
			$this->error404(lang("Status pending not found", "admin"));
		}

		if ($_POST) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$_POST["Active"] = (bool) $_POST["Active"];
				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Status pending edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes were saved", "admin"));
				$active = $_POST["action"];

				if ($active == "edit") {
					pjax("/admin/components/run/shop/notificationstatuses/edit/" . $id);
				}
				else {
					pjax("/admin/components/run/shop/notificationstatuses");
				}
			}
		}
		else {
			$model->setLocale($locale);
			$this->render("edit", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale));
		}
	}

	public function deleteAll()
	{
		if (!is_array($_POST["ids"]) || !0 < count($_POST["ids"])) {
			showMessage(lang("No data transmitted", "admin"), "", "r");
			exit();
		}

		$ids = $_POST["ids"];
		$PositionCount = $this->db->order_by("position")->get("shop_notification_statuses")->result_array();

		if ((count($PositionCount) == 1) && (count($ids) == 1)) {
			showMessage(lang("The last status in the list can not be deleted", "admin"), "", "r");
			exit();
		}

		if (count($ids) == count($PositionCount)) {
			array_shift($ids);
		}

		$model = SNotificationStatusesQuery::create()->findPks($ids);

		if (!empty($model)) {
			foreach ($model as $order ) {
				$order->delete();
			}

			$this->lib_admin->log(lang("Status pending removed", "admin") . ". Ids: " . implode(", ", $_POST["ids"]));
			showMessage(lang("Arrival notification status was deleted", "admin"));
		}
	}

	public function savePositions()
	{
		if (0 < sizeof($_POST["positions"])) {
			foreach ($_POST["positions"] as $id => $pos ) {
				SNotificationStatusesQuery::create()->filterById($pos)->update(array("Position" => (int) $id));
			}

			showMessage(lang("Positions saved", "admin"));
		}
	}
}


?>
