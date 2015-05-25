<?php

class ShopAdminCurrencies extends ShopAdminController
{
	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
	}

	public function index()
	{
		$model = SCurrenciesQuery::create()->orderById()->find();
		$this->render("list", array("model" => $model));
	}

	public function create()
	{
		$model = new SCurrencies();

		if ($_POST) {
			$_POST["Rate"] = strtr((double) $_POST["Rate"], ",", ".");
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$_POST["CurrencyTemplate"] = serialize(array("Thousands_separator" => ".", "Separator_tens" => ",", "Decimal_places" => "0", "Zero" => "0", "Format" => "# " . $_POST["Symbol"]));
				$model->fromArray($_POST);
				$model->save();
				$this->lib_admin->log(lang("Currency created", "admin") . " - " . $_POST["Name"]);
				$this->cache->delete_all();
				showMessage(lang("Currency created", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/currencies");
				}
				else {
					pjax("/admin/components/run/shop/currencies/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->render("create", array("model" => $model));
		}
	}

	public function edit($id)
	{
		$model = SCurrenciesQuery::create()->findPk($id);

		if ($model === NULL) {
			$this->error404(lang("Currency not found", "admin"));
		}

		$CurrencyTemplate = unserialize($model->getCurrencyTemplate());
		if (!$CurrencyTemplate || !$CurrencyTemplate["Format"]) {
			Currency\AdminCurrency::create()->editCurrencyFormat($id, "# " . $model->getSymbol(), ".", ",", "1", "1");
			$CurrencyTemplate["Thousands_separator"] = ".";
			$CurrencyTemplate["Separator_tens"] = ",";
			$CurrencyTemplate["Decimal_places"] = "1";
			$CurrencyTemplate["Zero"] = "1";
			$CurrencyTemplate["Format"] = "# " . $model->getSymbol();
		}

		$MainCurrencyId = Currency\Currency::create()->getMainCurrency();
		$mainDecimal = unserialize($MainCurrencyId->getCurrencyTemplate());
		$mainDecimal = $mainDecimal["Decimal_places"];
		$MainCurrencyId = $MainCurrencyId->getId();

		if ($_POST) {
			$_POST["Rate"] = strtr((double) $_POST["Rate"], ",", ".");
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$format = strtr($_POST["Format"], array($_POST["SymbolOld"] => $_POST["Symbol"]));
				unset($_POST["SymbolOld"]);
				$_POST["CurrencyTemplate"] = serialize(array("Thousands_separator" => $_POST["Thousands_separator"], "Separator_tens" => $_POST["Separator_tens"], "Decimal_places" => $_POST["Decimal_places"], "Zero" => $_POST["Zero"] ? "1" : "0", "Format" => $format));
				$model->fromArray($_POST);
				$model->save();

				if ($id == $MainCurrencyId) {
					$ShopCurrency = $this->db->get("shop_currencies")->result_array();

					foreach ($ShopCurrency as $value ) {
						$CurrentCurrencyItem = unserialize($value["currency_template"]);

						if ($_POST["Decimal_places"] < $CurrentCurrencyItem["Decimal_places"]) {
							$CurrentCurrencyItem["Decimal_places"] = $_POST["Decimal_places"];
							$this->db->where("id", $value["id"])->update("shop_currencies", array("currency_template" => serialize($CurrentCurrencyItem)));
						}
					}
				}

				Currency\Currency::create()->checkPrices();
				$this->lib_admin->log(lang("Currency was updated", "admin") . " - " . $_POST["Name"]);
				$this->cache->delete_all();
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/currencies");
				}
				else {
					pjax("/admin/components/run/shop/currencies/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->render("edit", array("model" => $model, "currFormat" => $CurrencyTemplate, "mainDecimal" => $mainDecimal));
		}
	}

	public function showOnSite()
	{
		if ($_POST) {
			$this->db->where("id !=", (int) $_POST["id"])->update("shop_currencies", array("showOnSite" => 0));
			$model = SCurrenciesQuery::create()->findPk((int) $_POST["id"]);

			if ($model === NULL) {
				$this->error404(lang("Currency not found", "admin"));
			}

			$model->setShowOnSite((int) $_POST["showOnSite"]);
			$model->save();

			if ($model != NULL) {
				$this->lib_admin->log(lang("Additional currency was edited", "admin") . " - " . $model->getName());
			}
		}
	}

	public function makeCurrencyDefault($idDb)
	{
		if (1 < count(SCurrenciesQuery::create()->find())) {
			$id = (int) $_POST["id"];

			if ($id == $idDb) {
				return;
			}

			$model = SCurrenciesQuery::create()->findPk($id);

			if ($model !== NULL) {
				SCurrenciesQuery::create()->update(array("IsDefault" => false));
				$model->setIsDefault(true);

				if ($model->save()) {
					echo true;
				}
			}
		}
	}

	public function makeCurrencyMain()
	{
		$MainCurrencyId = $this->db->where("main", 1)->get("shop_currencies")->row();
		$this->makeCurrencyDefault($MainCurrencyId->id);

		if (1 < count(SCurrenciesQuery::create()->find())) {
			$id = (int) $_POST["id"];

			if ($id == $MainCurrencyId->id) {
				return;
			}

			$recount = $_POST["recount"];
			$this->db->update("shop_payment_methods", array("currency_id" => $id));
			$model = SCurrenciesQuery::create()->findPk($id);

			if ($model !== NULL) {
				if ($model->getMain()) {
					return true;
				}

				SCurrenciesQuery::create()->update(array("Main" => false));
				$model->setMain(true);

				if ($model->save()) {
					echo true;
				}

				$ShopCurrency = $this->db->get("shop_currencies")->result_array();
				$mainDecimal = unserialize($MainCurrencyId->currency_template);
				$mainDecimal = $mainDecimal["Decimal_places"];

				foreach ($ShopCurrency as $value ) {
					$CurrentCurrencyItem = unserialize($value["currency_template"]);

					if ($mainDecimal < $CurrentCurrencyItem["Decimal_places"]) {
						$CurrentCurrencyItem["Decimal_places"] = $mainDecimal;
						$this->db->where("id", $value["id"])->update("shop_currencies", array("currency_template" => serialize($CurrentCurrencyItem)));
					}
				}

				if ($model !== NULL) {
					$this->lib_admin->log(lang("Main currency was edited", "admin") . " - " . $model->getName());
				}

				if (Currency\Currency::create()->checkPrices()) {
					if ($recount == "1") {
					}
				}
			}
		}
	}

	public function delete()
	{
		$model = SCurrenciesQuery::create()->findPk($_POST["ids"]);

		if ($model !== NULL) {
			if ($model->getMain() == true) {
				$response = showMessage(lang("Unable to remove the main currency", "admin"), false, "r", true);
				echo json_encode(array("response" => $response));
				exit();
			}

			$PaymetMetodsCount = SPaymentMethodsQuery::create()->filterByCurrencyId($model->getId())->count();

			if (0 < $PaymetMetodsCount) {
				$response = showMessage(lang("Unable to remove currency. The currency used in the payment methods.", "admin"), false, "r", true);
				echo json_encode(array("response" => $response));
				exit();
			}

			$ProductVariantsCount = SProductVariantsQuery::create()->filterByCurrency($model->getId())->count();

			if (0 < $ProductVariantsCount) {
				$response = showMessage(lang("Error. The currency used in the products. Check the currency options products", "admin"), false, "r", true);
				$recount = true;
				echo json_encode(array("response" => $response, "recount" => $recount, "id" => $model->getId()));
				exit();
			}

			$model->delete();
			$this->lib_admin->log(lang("Currency successfully removed", "admin") . " - " . $model->getName());
			$response = showMessage(lang("Currency successfully removed", "admin"), false, "", true);
			echo json_encode(array("response" => $response, "success" => true));
		}
	}

	public function recount()
	{
		$id = $this->input->post("id");
		$id = (int) $id;
		$rate = Currency\Currency::create()->getRateById($id);
		$main_id = Currency\Currency::create()->main->id;
		$this->db->query("UPDATE `shop_product_variants` SET `price_in_main` = `price` WHERE `currency` =" . $id);
		$this->db->where("currency", $id)->update("shop_product_variants", array("currency" => $main_id));
		showMessage(lang("Conversion completed. Now the currency may be removed", "admin"));
	}

	public function checkPrices()
	{
		if (Currency\Currency::create()->checkPrices()) {
			showMessage(lang("Prices updated", "admin"));
		}
		else {
			showMessage(lang("There was no price for the upgrade", "admin"));
		}
	}
}


?>
