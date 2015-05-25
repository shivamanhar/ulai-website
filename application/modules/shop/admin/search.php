<?php

class ShopAdminSearch extends ShopAdminController
{
	public $perPage = 5;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();

		if (!$_COOKIE["per_page"]) {
			setcookie("per_page", ShopCore::app()->SSettings->adminProductsPerPage, time() + 604800, "/", $_SERVER["HTTP_HOST"]);
			$this->perPage = ShopCore::app()->SSettings->adminProductsPerPage;
		}
		else {
			$this->perPage = $_COOKIE["per_page"];
		}

		$this->defaultLanguage = getDefaultLanguage();
	}

	public function test()
	{
		$c = SCategoryQuery::create()->where("SCategory.Id = ?", 928)->findOne();
		$c->delete();
	}

	public function per_page_cookie()
	{
		setcookie("per_page", (int) $_GET["count_items"], time() + 604800, "/", $_SERVER["HTTP_HOST"]);
	}

	public function index()
	{
		$model = SProductsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->leftJoinBrand()->addSelectModifier("SQL_CALC_FOUND_ROWS")->leftJoinProductVariant();

		if (isset(ShopCore::$_GET["WithoutImages"]) && ((int) ShopCore::$_GET["WithoutImages"] == 1)) {
			$model->where("(shop_product_variants.mainImage=\"\" or shop_product_variants.mainImage IS NULL)");
		}

		if (isset(ShopCore::$_GET["CategoryId"]) && (0 < ShopCore::$_GET["CategoryId"])) {
			$category = SCategoryQuery::create()->filterById((int) ShopCore::$_GET["CategoryId"])->findOne();

			if ($category) {
				$model = $model->filterByCategory($category);
			}
		}

		if (isset(ShopCore::$_GET["filterID"]) && (0 < ShopCore::$_GET["filterID"])) {
			$model = $model->filterById((int) ShopCore::$_GET["filterID"]);
		}

		if (isset(ShopCore::$_GET["sku"]) && (ShopCore::$_GET["sku"] != "")) {
			$model = $model->where("ProductVariant.Number LIKE ?", "%" . ShopCore::$_GET["sku"] . "%");
		}

		if (!empty(ShopCore::$_GET["text"])) {
			$text = ShopCore::$_GET["text"];

			if (!strpos($text, "%")) {
				$text = "%" . $text . "%";
			}

			$model->condition("name", "SProductsI18n.Name LIKE ?", $text);
			$model->where(array("name"), Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR);
		}

		if (isset(ShopCore::$_GET["min_price"]) && (0 < ShopCore::$_GET["min_price"])) {
			$model = $model->where("ProductVariant.Price >= ?", ShopCore::$_GET["min_price"]);
		}

		if (isset(ShopCore::$_GET["max_price"]) && (0 < ShopCore::$_GET["max_price"])) {
			$model = $model->where("ProductVariant.Price <= ?", ShopCore::$_GET["max_price"]);
		}

		if (ShopCore::$_GET["Active"] == "true") {
			$model = $model->filterByActive(true);
		}
		else if ($this->input->get("Active") == "false") {
			$model = $model->filterByActive(false);
		}

		if (isset(ShopCore::$_GET["s"])) {
			if (ShopCore::$_GET["s"] == "Hit") {
				$model = $model->filterByHit(true);
			}

			if (ShopCore::$_GET["s"] == "Hot") {
				$model = $model->filterByHot(true);
			}

			if (ShopCore::$_GET["s"] == "Action") {
				$model = $model->filterByAction(true);
			}
		}

		if (isset(ShopCore::$_GET["orderMethod"]) && (ShopCore::$_GET["orderMethod"] != "")) {
			$order_methods = array("Id", "Name", "CategoryName", "Price", "Active", "Reference");

			if (in_array(ShopCore::$_GET["orderMethod"], $order_methods)) {
				switch (ShopCore::$_GET["orderMethod"]) {
				case "Name":
					$model = $model->useSProductsI18nQuery()->orderByName(ShopCore::$_GET["order"])->endUse();
				case "Price":
					$model = $model->useProductVariantQuery()->orderByPrice(ShopCore::$_GET["order"])->endUse();
				case "Reference":
					$model = $model->useProductVariantQuery()->orderByNumber(ShopCore::$_GET["order"])->endUse();
				case "CategoryName":
					$model = $model->useMainCategoryQuery()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderBy("SCategoryI18n.Name", ShopCore::$_GET["order"])->endUse();
				default :
					$model = $model->useSProductsI18nQuery()->orderById(ShopCore::$_GET["order"])->endUse();
				break;
				}
			}
		}
		else {
			$model = $model->orderById(Propel\Runtime\ActiveQuery\Criteria::DESC);
		}

		if (0 < sizeof(ShopCore::$_GET["productProperties"])) {
			$combine = $this->_buildCombinatorArray(ShopCore::$_GET["productProperties"]);

			if ($combine !== false) {
				$model = $model->combinator($combine);
			}
		}

		$model = $model->offset((int) ShopCore::$_GET["per_page"])->limit($this->perPage)->distinct()->find();
		$totalProducts = $this->getTotalRow();
		$model->populateRelation("ProductVariant");
		$model->populateRelation("MainCategory");

		if (!empty(ShopCore::$_GET)) {
			session_start();
			$_SESSION["ref_url"] = "?" . http_build_query(ShopCore::$_GET);
		}
		else {
			unset($_SESSION["ref_url"]);
		}

		$this->load->library("pagination");
		$config["base_url"] = "/admin/components/run/shop/search/index/?" . http_build_query(ShopCore::$_GET);
		$config["container"] = "shopAdminPage";
		$config["page_query_string"] = true;
		$config["uri_segment"] = 8;
		$config["total_rows"] = $totalProducts;
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

		if (0 < ShopCore::$_GET["CategoryId"]) {
			$CategoryModel = SCategoryQuery::create()->findPk(ShopCore::$_GET["CategoryId"]);

			if ($CategoryModel !== NULL) {
				$renderer = ShopCore::app()->SPropertiesRenderer;
				$renderer->useMultipleSelect = true;
				$this->template->assign("fieldsForm", $renderer->renderAdmin($CategoryModel->getId()));
			}
		}

		$tree = Category\CategoryApi::getInstance()->getTree();
		$this->render("list", array("tree" => $tree, "products" => $model, "categories" => ShopCore::app()->SCategoryTree->getTree(), "totalProducts" => $totalProducts, "pagination" => $this->pagination->create_links_ajax(), "filter_url" => http_build_query(ShopCore::$_GET), "cur_uri_str" => base64_encode($this->uri->uri_string() . "?" . http_build_query(ShopCore::$_GET))));
	}

	public function save_positions_variant()
	{
		$positions = $_POST["positions"];

		if (sizeof($positions) == 0) {
			return false;
		}

		foreach ($positions as $key => $val ) {
			$query = "UPDATE `shop_product_variants` SET `position`=" . $key . " WHERE `id`=" . (int) $val . "; ";
			$this->db->query($query);
		}

		showMessage(lang("Positions saved", "admin"));
	}

		protected function _buildCombinatorArray(array $data)
	{
		$resultData = array();

		foreach ($data as $fieldId => $fieldValue ) {
			$field = SPropertiesQuery::create()->filterByActive(true)->findPk($fieldId);

			if (($field !== NULL) && !empty($fieldValue)) {
				if (is_array($fieldValue)) {
					$resultData[$fieldId] = $fieldValue;
				}
				else {
					$resultData[$fieldId][] = $fieldValue;
				}
			}
		}

		if (!empty($resultData)) {
			return $resultData;
		}

		return false;
	}

	private function _advanced_search_by_term($term, $fullData = false)
	{
		$model = SProductsQuery::create()->leftJoinProductVariant();
		$model = $model->useI18nQuery($this->defaultLanguage["identif"])->where("SProductsI18n.Name LIKE ?", "%" . $term . "%")->endUse()->_or()->where("ProductVariant.Number = ?", "%" . $term . "%")->distinct()->find();

		if ($fullData) {
			$select = "*";
		}
		else {
			$select = "username, phone, email";
		}

		if (1 < count(explode(" / ", $term))) {
			$term = explode(" / ", $term);
		}

		if (is_array($term)) {
			$users = $this->db->select($select)->where("username like '%$term[0]%'")->or_where("phone LIKE '%$term[1]%'")->or_where("email LIKE '%$term[2]%'")->get("users")->result_array();
		}
		else {
			$users = $this->db->select($select)->where("username like '%$term%'")->or_where("phone LIKE '%$term%'")->or_where("email LIKE '%$term%'")->get("users")->result_array();
		}

		return array("users" => $users, "model" => $model);
	}

	public function autocomplete()
	{
		if ($this->input->get("term")) {
			if ($this->ajaxRequest) {
				$tokens = array();
				$term = $this->input->get("term");
				extract($this->_advanced_search_by_term($term));

				foreach ($users as $u ) {
					if (strlen(trim($u["username"]))) {
						$tokens[] = $u["username"];
					}

					if (strlen(trim($u["phone"]))) {
						$tokens[] = $u["phone"];
					}

					if (strlen(trim($u["email"]))) {
						$tokens[] = $u["email"];
					}
				}

				foreach ($model as $p ) {
					if (strlen(trim($p->getName()))) {
						$tokens[] = $p->getName();
					}

					if (strlen(trim($p->getFirstVariant()->getNumber()))) {
						$tokens[] = $p->getFirstVariant()->getNumber();
					}
				}

				echo json_encode(array_values(array_unique($tokens)));
			}
			else {
				redirect("/admin/components/run/shop/dashboard");
			}
		}
	}

	public function advanced()
	{
		$data = trim($this->input->get("q"));
		$data = strip_tags($data);
		$data = htmlspecialchars($data, ENT_QUOTES);
		$searchText = $this->security->xss_clean($data);

		if (strlen($searchText)) {
			$this->render("advanced", $this->_advanced_search_by_term($searchText, true));
		}
		else {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	public function renderCustomFields($categoryId = NULL)
	{
		$renderer = ShopCore::app()->SPropertiesRenderer;
		$renderer->useMultipleSelect = true;
		echo $renderer->renderAdmin($categoryId);
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
