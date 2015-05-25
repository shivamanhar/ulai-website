<?php

class ShopAdminDeliverymethods extends ShopAdminController
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
		$model = SDeliveryMethodsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$this->render("list", array("model" => $model));
	}

	public function create()
	{
		$model = new SDeliveryMethods();
		$model->setLocale($this->defaultLanguage["identif"]);

		if ($_POST) {
			$_POST["Description"] = strtr($_POST["Description"], array("\"" => "&quot;"));

			if (substr(trim($_POST["Price"], " "), -1) == "%") {
				$_POST["IsPriceInPercent"] = true;
			}
			else {
				$_POST["IsPriceInPercent"] = false;
			}

			if (!$_POST["delivery_sum_specified"]) {
				$model->fromArray($_POST);
				$this->form_validation->set_rules($model->rules(false));
			}
			else {
				$model->fromArray($_POST);
				$this->form_validation->set_rules($model->rules(true));
			}

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$model->setPricedescription($this->input->post("pricedescription"));
				$model->save();
				ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($model->getId())->delete();
				$model->setDeliverySumSpecified((int) $this->input->post("delivery_sum_specified"));
				$model->setDeliverySumSpecifiedMessage($this->input->post("delivery_sum_specified_message"));

				if (0 < sizeof($_POST["paymentMethods"])) {
					foreach ($_POST["paymentMethods"] as $key => $val ) {
						$pm = SPaymentMethodsQuery::create()->findPk($val);

						if ($pm instanceof SPaymentMethods) {
							$model->addPaymentMethods($pm);
						}
					}
				}

				$model->save();
				$shop_delivery_methods = $this->db->order_by("id", "desc")->get("shop_delivery_methods")->row()->id;
				$this->lib_admin->log(lang("Delivery created", "admin") . ". Id: " . $shop_delivery_methods);
				showMessage(lang("Delivery created", "admin"));

				if ($_POST["action"] == "close") {
					pjax("/admin/components/run/shop/deliverymethods/index");
				}
				else {
					pjax("/admin/components/run/shop/deliverymethods/edit/" . $model->getId() . "/" . $locale);
				}
			}
		}
		else {
			$this->render("create", array("model" => $model, "paymentMethods" => SPaymentMethodsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find()));
		}
	}

	public function change_delivery_status($id)
	{
		$model = SDeliveryMethodsQuery::create()->findPk($id);

		if ($model->getEnabled()) {
			$model->setEnabled("0");
		}
		else {
			$model->setEnabled("1");
		}

		$model->save();
		$this->lib_admin->log(lang("Status delivery was edited", "admin") . ". Id: " . $id);
	}

	public function edit($deliveryMethodId = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SDeliveryMethodsQuery::create()->findPk((int) $deliveryMethodId);

		if ($model === NULL) {
			$this->error404(lang("Delivery method is not found", "admin"));
		}

		if (!empty($_POST)) {
			$_POST["Description"] = strtr($_POST["Description"], array("\"" => "&quot;"));

			if (!$_POST["delivery_sum_specified"]) {
				$this->form_validation->set_rules($model->rules(false));
			}
			else {
				$this->form_validation->set_rules($model->rules(true));
			}

			if (substr(trim($_POST["Price"], " "), -1) == "%") {
				$_POST["IsPriceInPercent"] = true;
			}
			else {
				$_POST["IsPriceInPercent"] = false;
			}

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				if (!$_POST["Enabled"]) {
					$_POST["Enabled"] = false;
				}

				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->setDeliverySumSpecified((int) $this->input->post("delivery_sum_specified"));
				$model->setDeliverySumSpecifiedMessage($this->input->post("delivery_sum_specified_message"));
				$model->setPricedescription($this->input->post("pricedescription"));
				$model->setDescription($this->input->post("Description"));
				$model->save();
				ShopDeliveryMethodsSystemsQuery::create()->filterByDeliveryMethodId($model->getId())->delete();

				if (0 < sizeof($_POST["paymentMethods"])) {
					foreach ($_POST["paymentMethods"] as $key => $val ) {
						$pm = SPaymentMethodsQuery::create()->findPk($val);

						if ($pm instanceof SPaymentMethods) {
							$model->addPaymentMethods($pm);
						}
					}
				}

				$model->setDescription($this->input->post("Description"));
				$model->save();
				$this->lib_admin->log(lang("Delivery was edited", "admin") . ". Id: " . $deliveryMethodId);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "close") {
					pjax("/admin/components/run/shop/deliverymethods/edit/" . $deliveryMethodId . "/" . $locale);
				}
				else {
					pjax("/admin/components/run/shop/deliverymethods/index");
				}
			}
		}
		else {
			$model->setLocale($locale);
			$this->render("edit", array("descr" => strtr($model->getDescription(), array("&quot;" => "\"")), "descrPrice" => strtr($model->getpriceDescription(), array("&quot;" => "\"")), "model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "paymentMethods" => SPaymentMethodsQuery::create()->joinWithI18n($locale, Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition()->find(), "locale" => $locale));
		}
	}

	public function deleteAll()
	{
		if (empty($_POST["ids"])) {
			showMessage(lang("No data transmitted", "admin"), "", "r");
			exit();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SDeliveryMethodsQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $order ) {
					$order->delete();
				}

				$this->lib_admin->log(lang("Delivery was removed", "admin") . ". Ids: " . implode(", ", $_POST["ids"]));
				showMessage(lang("Delivery method removed", "admin"));
			}
		}
	}

	protected function redirect($model = NULL, $locale = NULL)
	{
		if ($_POST["_add"]) {
			$this->ajaxShopDiv("deliverymethods/index");
		}

		if ($_POST["_create"]) {
			$this->ajaxShopDiv("deliverymethods/create");
		}

		if ($_POST["_edit"]) {
			$this->ajaxShopDiv("deliverymethods/edit/" . $model->getId() . "/" . $locale);
		}
	}

	public function save_positions()
	{
		$positions = $_POST["positions"];

		if (sizeof($positions) == 0) {
			return false;
		}

		foreach ($positions as $key => $val ) {
			$query = "UPDATE `shop_delivery_methods` SET `position`=" . $key . " WHERE `id`=" . (int) $val . "; ";
			$this->db->query($query);
		}

		showMessage(lang("Positions saved", "admin"));
	}
}


?>
