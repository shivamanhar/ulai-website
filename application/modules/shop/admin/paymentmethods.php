<?php

class ShopAdminPaymentmethods extends ShopAdminController
{
	public $defaultLanguage;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
		$lang = new MY_Lang();
		$modules = $this->db->like("name", "payment_method_")->get("components")->result_array();

		foreach ($modules as $value ) {
			$lang->load($value["name"]);
		}
	}

	public function index()
	{
		$model = SPaymentMethodsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find();
		$this->render("list", array("model" => $model));
	}

	public function create()
	{
		$model = new SPaymentMethods();

		if ($_POST) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$model->fromArray($_POST);
				$position = SPaymentMethodsQuery::create()->select("Position")->orderByPosition("Desc")->limit(1)->find();
				$model->setPosition($position[0] + 1);
				$model->save();
				$shop_payment_methods = $this->db->order_by("id", "desc")->get("shop_payment_methods")->row()->id;
				$this->lib_admin->log(lang("Payment method is created", "admin") . ". Id: " . $shop_payment_methods);
				showMessage(lang("Payment method is created", "admin"));

				if ($_POST["action"] == "exit") {
					pjax("/admin/components/run/shop/paymentmethods/index");
				}
				else {
					pjax("/admin/components/run/shop/paymentmethods/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->render("create", array("model" => $model, "paymentSystemForm" => $paymentSystemForm, "currencies" => SCurrenciesQuery::create()->find()));
		}
	}

	public function change_payment_status($id)
	{
		$model = SPaymentMethodsQuery::create()->findPk($id);

		if ($model->getActive()) {
			$model->setActive("0");
		}
		else {
			$model->setActive("1");
		}

		$model->save();
		$this->lib_admin->log(lang("Status payment was edited", "admin") . ". Id: " . $id);
	}

	public function edit($id, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SPaymentMethodsQuery::create()->findPk((int) $id);

		if ($model === NULL) {
			$this->error404(lang("Payment method is not found.", "admin"));
		}

		$PaymentSystemName = $this->load->module($model->getPaymentSystemName());

		if (($model->getPaymentSystemName() != NULL) && method_exists($PaymentSystemName, "getForm")) {
			$PaymentSystemName->paymentMethod = $model;
			$paymentSystemForm = $PaymentSystemName->getAdminForm($id);
		}

		if ($_POST) {
			$PaymentSystemName = $this->load->module($_POST["PaymentSystemName"]);

			if (method_exists($PaymentSystemName, "saveSettings")) {
				$result = $PaymentSystemName->saveSettings($model);

				if ($result !== true) {
					showMessage($result, "", "r");
					exit();
				}
			}

			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$_POST["Active"] = (bool) $_POST["Active"];
				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Payment method was edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "edit") {
					pjax("/admin/components/run/shop/paymentmethods/edit/" . $id);
				}
				else {
					pjax("/admin/components/run/shop/paymentmethods");
				}
			}
		}
		else {
			$model->setLocale($locale);
			$this->render("edit", array("model" => $model, "currencies" => SCurrenciesQuery::create()->find(), "paymentSystemForm" => $paymentSystemForm, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale, "lang" => $this->db->where("locale", $this->config->item("language"))->get("languages")->row()->identif));
		}
	}

	public function deleteAll()
	{
		if (empty($_POST["ids"])) {
			showMessage(lang("No data transmitted", "admin"), "", "r");
			exit();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SPaymentMethodsQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $order ) {
					$order->delete();
				}

				$this->lib_admin->log(lang("Method of payment is removed", "admin") . ". Ids: " . implode(", ", $_POST["ids"]));
				showMessage(lang("Method of payment is removed", "admin"));
			}
		}
	}

	public function savePositions()
	{
		if (0 < sizeof($_POST["positions"])) {
			foreach ($_POST["positions"] as $id => $pos ) {
				SPaymentMethodsQuery::create()->filterById($pos)->update(array("Position" => (int) $id));
			}

			showMessage(lang("Positions saved", "admin"));
		}
	}

	protected function _redirect($model = NULL, $locale = NULL)
	{
		if ($_POST["_add"]) {
			$redirect_url = "paymentmethods/index";
		}

		if ($_POST["_create"]) {
			$redirect_url = "paymentmethods/create";
		}

		if ($_POST["_edit"]) {
			$redirect_url = "paymentmethods/edit/" . $model->getId() . "/" . $locale;
		}

		if ($redirect_url !== false) {
			$this->ajaxShopDiv($redirect_url);
		}
	}

	public function getAdminForm($systemName = NULL, $paymentMethodId = NULL)
	{
		$class = $this->load->module($systemName);

		if (is_object($class)) {
			$class->paymentMethod = SPaymentMethodsQuery::create()->findPk($paymentMethodId);
			echo $class->getAdminForm();
		}
	}
}


?>

