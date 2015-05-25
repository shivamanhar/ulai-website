<?php

class ShopAdminProperties extends ShopAdminController
{
	public $defaultLanguage;
	public $perPage = 5;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->load->helper("translit");
		$this->defaultLanguage = getDefaultLanguage();
		session_start();

		if (!$_COOKIE["per_page"]) {
			setcookie("per_page", ShopCore::app()->SSettings->adminProductsPerPage, time() + 604800, "/", $_SERVER["HTTP_HOST"]);
			$this->perPage = ShopCore::app()->SSettings->adminProductsPerPage;
		}
		else {
			$this->perPage = $_COOKIE["per_page"];
		}
	}

	public function per_page_cookie()
	{
		setcookie("per_page", (int) $_GET["count_items"], time() + 604800, "/", $_SERVER["HTTP_HOST"]);
	}

	public function index($categoryId = NULL)
	{
		$_SESSION["cat_id"] = $categoryId;
		if (($categoryId === NULL) || ($categoryId == 0)) {
			$model = SPropertiesQuery::create()->joinWithI18n(MY_Controller::defaultLocale());
			$category = NULL;
		}
		else {
			$category = SCategoryQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->findPk((int) $categoryId);

			if ($category !== NULL) {
				$model = SPropertiesQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->filterByPropertyCategory($category);
			}
		}

		if (isset(ShopCore::$_GET["filterID"]) && (0 < ShopCore::$_GET["filterID"])) {
			$model = $model->filterById((int) ShopCore::$_GET["filterID"]);
		}

		if (isset(ShopCore::$_GET["Property"]) && ShopCore::$_GET["Property"]) {
			$model = $model->useSPropertiesI18nQuery()->filterByLocale(MY_Controller::defaultLocale())->where("SPropertiesI18n.Name LIKE ?", "%" . ShopCore::$_GET["Property"] . "%")->endUse();
		}

		if (isset(ShopCore::$_GET["CSVName"]) && ShopCore::$_GET["CSVName"]) {
			$model = $model->where("SProperties.CsvName LIKE ?", "%" . ShopCore::$_GET["CSVName"] . "%");
		}

		if (ShopCore::$_GET["Active"] == "true") {
			$model = $model->filterByActive(true);
		}
		else if ($this->input->get("Active") == "false") {
			$model = $model->filterByActive(false);
		}

		if (isset(ShopCore::$_GET["orderMethod"]) && (ShopCore::$_GET["orderMethod"] != "")) {
			$prop_table = array("Id", "Property", "CSVName", "Status");

			if (in_array(ShopCore::$_GET["orderMethod"], $prop_table)) {
				switch (ShopCore::$_GET["orderMethod"]) {
				case "Id":
					$model = $model->orderById(ShopCore::$_GET["order"]);
				case "Property":
					$model = $model->useSPropertiesI18nQuery()->filterByLocale(MY_Controller::defaultLocale())->orderByName(ShopCore::$_GET["order"])->endUse();
				case "CSVName":
					$model = $model->orderByCsvName(ShopCore::$_GET["order"]);
				case "Status":
					$model = $model->orderByActive(ShopCore::$_GET["order"]);
				}
			}
		}

		$model_query = clone $model;
		$model_query = $model_query->distinct()->find();
		$total_row = $this->getTotalRow();
		$model = $model->offset((int) ShopCore::$_GET["per_page"])->limit($this->perPage)->distinct()->_if(!ShopCore::$_GET["orderMethod"])->orderByPosition()->_endIf()->find();
		$this->load->library("pagination");
		$config["base_url"] = "/admin/components/run/shop/properties/index/" . $categoryId . "/?" . http_build_query(ShopCore::$_GET);
		$config["container"] = "shopAdminPage";
		$config["page_query_string"] = true;
		$config["uri_segment"] = 8;
		$config["total_rows"] = $total_row;
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
		$this->pagination->initialize($config);
		$categories = $this->db->where("locale", MY_Controller::defaultLocale())->get("shop_category_i18n")->result_array();
		$catName = array();

		foreach ($categories as $c ) {
			$catName[$c["id"]]["name"] = $c["name"];
		}

		$product_properties_categories = $this->db->get("shop_product_properties_categories")->result_array();
		$product_properties_categories_array = array();

		foreach ($product_properties_categories as $product_properties_categories_item ) {
			$product_properties_categories_array[$product_properties_categories_item["property_id"]][] = $catName[$product_properties_categories_item["category_id"]]["name"];
		}

		$this->render("list", array("model" => $model, "categories" => ShopCore::app()->SCategoryTree->getTree_(), "filterCategory" => $category, "pagination" => $this->pagination->create_links_ajax(), "locale" => $this->defaultLanguage["identif"], "p_cat" => $product_properties_categories_array));
	}

	public function create()
	{
		$locale = (array_key_exists("Locale", $_POST) ? $_POST["Locale"] : $this->defaultLanguage["identif"]);
		$model = new SProperties();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				if (!$_POST["CsvName"]) {
					$_POST["CsvName"] = translit($_POST["Name"]);
				}

				if ($this->checkCsvName($this->input->post("CsvName"))) {
					showMessage(lang("Csv name is already used", "admin"), "", "r");
					return;
				}

				$model->fromArray($_POST);

				if (in_array("all", $_POST["UseInCategories"])) {
					$UseInCategories = SCategoryQuery::create()->find();

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}
				else if ((0 < sizeof($_POST["UseInCategories"])) && is_array($_POST["UseInCategories"])) {
					$ids = $this->input->post("UseInCategories");
					$UseInCategories = SCategoryQuery::create()->filterById($ids)->find();

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}

				$model->save();
				$this->lib_admin->log(lang("Property created", "admin") . ". Id: " . $model->getId());
				showMessage(lang("Property created", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/properties/index");
				}
				else {
					pjax("/admin/components/run/shop/properties/edit/" . $model->getId());
				}
			}
		}
		else {
			$this->render("create", array("model" => $model, "categories" => ShopCore::app()->SCategoryTree->getTree_(), "locale" => $this->defaultLanguage["identif"], "filter" => $_SESSION["cat_id"]));
		}
	}

	public function createPropFast()
	{
		if ($_POST) {
			$model = new SProperties();
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run() === false) {
				echo json_encode(array("error" => 1, "data" => validation_errors()));
				exit();
			}
			else {
				$locale = MY_Controller::getCurrentLocale();

				if (!$_POST["CsvName"]) {
					$_POST["CsvName"] = translit($_POST["Name"]);
				}

				if ($this->checkCsvName($_POST["CsvName"])) {
					echo json_encode(array("error" => 1, "data" => lang("Csv name is already used", "admin")));
					exit();
				}

				$_POST["Active"] = (int) $_POST["active"];
				$_POST["ShowOnSite"] = 1;
				$model->fromArray($_POST);
				$InCatFlag = false;

				foreach ($_POST["inCat"] as $inCat ) {
					if ($inCat == "0") {
						$InCatFlag = true;
					}
				}

				if ($InCatFlag) {
					$UseInCategories = SCategoryQuery::create()->find();

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}
				else {
					$UseInCategories = SCategoryQuery::create()->findById($_POST["inCat"]);

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}

				$model->save();
				$model->setPosition(-$model->getId());
				$model->save();
				$categories = $this->db->where("locale", MY_Controller::defaultLocale())->get("shop_category_i18n")->result_array();
				$catName = array();

				foreach ($categories as $c ) {
					$catName[$c["id"]]["name"] = $c["name"];
				}

				$product_properties_categories = $this->db->get("shop_product_properties_categories")->result_array();
				$product_properties_categories_array = array();

				foreach ($product_properties_categories as $product_properties_categories_item ) {
					$product_properties_categories_array[$product_properties_categories_item["property_id"]][] = $catName[$product_properties_categories_item["category_id"]]["name"];
				}

				$fastPropertyCreateView = $this->render("fastPropertyCreate", array("open_fast_create" => true), true);
				$onePropertyListView = $this->render("onePropertyListView", array("p" => $model, "p_cat" => $product_properties_categories_array), true);
				echo json_encode(array("error" => 0, "data" => lang("Property created", "admin"), "fastPropertyCreateView" => $fastPropertyCreateView, "onePropertyListView" => $onePropertyListView));
			}
		}
	}

	public function edit($propertyId = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$model = SPropertiesQuery::create()->findPk((int) $propertyId);

		if ($model === NULL) {
			$this->error404(lang("The property is not found", "admin"));
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->checkCsvName($this->input->post("CsvName"), $propertyId)) {
				showMessage(lang("Csv name is already used", "admin"), "", "r");
				return;
			}

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				if (!$_POST["Data"]) {
					$_POST["Data"] = "";
				}

				$checkboxes = array("Active", "ShowInCompare", "ShowInFilter", "ShowOnSite", "Multiple", "MainProperty", "ShowFaq");

				foreach ($checkboxes as $name ) {
					$_POST[$name] = (isset($_POST[$name]) ? 1 : 0);
				}

				$model->fromArray($_POST);
				$this->deleteProductPropertiesData($model, $_POST["UseInCategories"]);
				ShopProductPropertiesCategoriesQuery::create()->filterByPropertyId($model->getId())->delete();

				if (in_array("all", $_POST["UseInCategories"])) {
					$UseInCategories = SCategoryQuery::create()->find();

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}
				else if ((0 < sizeof($_POST["UseInCategories"])) && is_array($_POST["UseInCategories"])) {
					$ids = $this->input->post("UseInCategories");
					$UseInCategories = SCategoryQuery::create()->filterById($ids)->find();

					foreach ($UseInCategories as $category ) {
						$model->addPropertyCategory($category);
					}
				}

				$model->save();
				$this->lib_admin->log(lang("Property edited", "admin") . ". Id: " . $propertyId);
				showMessage(lang("Changes saved", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/properties/index");
				}

				if ($_POST["action"] == "tocreate") {
					pjax("/admin/components/run/shop/properties/create");
				}

				if ($_POST["action"] == "toedit") {
					pjax("/admin/components/run/shop/properties/edit/" . $model->getId());
				}
			}
		}
		else {
			$model->setLocale($locale);
			$propertyCategories = array();

			foreach ($model->getPropertyCategories() as $PropertyCategory ) {
				array_push($propertyCategories, $PropertyCategory->getId());
			}

			$this->render("edit", array("model" => $model, "categories" => ShopCore::app()->SCategoryTree->getTree_(SCategoryTree::MODE_SINGLE, $locale), "propertyCategories" => $propertyCategories, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale, "filter" => $_SESSION["cat_id"]));
		}
	}

	private function deleteProductPropertiesData($model, $currentUseInCategories)
	{
	
		$ShopProductPropertiesCategories = ShopProductPropertiesCategoriesQuery::create()->filterByPropertyId($model->getId())->find()->toArray();
		$CategoryIds = array();

		if ($ShopProductPropertiesCategories) {
			foreach ($ShopProductPropertiesCategories as $PropertyCategory ) {
				$CategoryIds[] = (string) $PropertyCategory["CategoryId"];
			}

			$CatIds = array_diff($CategoryIds, $currentUseInCategories);

			if ($CatIds) {
				$products = SProductsQuery::create()->orderById()->filterByCategoryId($CatIds)->find();
				$CatProdId = array();

				foreach ($products as $product ) {
					$CatProdId[] = $product->getId();
				}

				if ($CatProdId) {
					SProductPropertiesDataQuery::create()->filterByProductId($CatProdId)->filterByPropertyId($model->getId())->delete();
				}
			}
		}
	}

	public function checkCsvName($csvName = "", $propertyId = NULL)
	{
		$this->db->where("csv_name", $csvName);

		if ($propertyId != NULL) {
			$this->db->where("id <>", $propertyId);
		}

		$result = $this->db->get("shop_product_properties")->row_array();

		if ($result) {
			$this->form_validation->set_message("checkCsvName", lang("Csv name is already used", "admin"));
			return true;
		}

		return false;
	}

	public function renderForm($categoryId, $productId = NULL)
	{
		$result = ShopCore::app()->SPropertiesRenderer->renderAdmin($categoryId, SProductsQuery::create()->findPk((int) $productId));

		if ($result == false) {
			echo "<div id=\"notice\" style=\"width: 500px;\">" . lang("The list of properties is empty", "admin") . "
						<a href=\"#\" onclick=\"ajaxShop('properties/create'); return false;\">" . lang("Create", "admin") . ".</a>
					</div>";
		}
		else {
			echo $result;
		}
	}

	public function save_positions()
	{
		$positions = $_POST["positions"];

		if (sizeof($positions) == 0) {
			return false;
		}

		$arr = "(";
		$i = 0;

		foreach (array_values($positions) as $item ) {
			$arr .= "'" . $item . "'";

			if ($i < (count($positions) - 1)) {
				$arr .= ", ";
			}
			else {
				$arr .= ")";
			}

			++$i;
		}

		$result = $this->db->query("SELECT `position` FROM `shop_product_properties` WHERE `id` IN " . $arr)->result_array();

		foreach ($result as $key => $item ) {
			$positions_to_insert[(int) $item["position"]] = $positions[$key];
		}

		foreach ($positions as $key => $val ) {
			$query = "UPDATE `shop_product_properties` SET `position`=" . $key . " WHERE `id`=" . (int) $val . "; ";
			$this->db->query($query);
		}

		showMessage(lang("Positions saved", "admin"));
	}

	public function delete()
	{
		$id = $_POST["ids"];
		$model = SPropertiesQuery::create()->findPks($id);

		if ($model === NULL) {
			return false;
		}

		$model->delete();
		$this->lib_admin->log(lang("The property(ies) deleted", "admin") . ". Ids: " . implode(", ", $id));
		showMessage(lang("The property(ies) deleted", "admin"), lang("Message", "admin"));
		pjax("/admin/components/run/shop/properties/index");
	}

	public function changeActive()
	{
		$id = $this->input->post("id");
		$prop = $this->db->where("id", $id)->get("shop_product_properties")->row();
		$active = $prop->active;

		if ($active == 1) {
			$active = 0;
		}
		else {
			$active = 1;
		}

		if ($this->db->where("id", $id)->update("shop_product_properties", array("active" => $active))) {
			showMessage(lang("Change saved successfully", "admin"));
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
}


?>
