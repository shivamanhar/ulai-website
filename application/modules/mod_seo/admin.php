<?php

defined("BASEPATH") || exit("No direct script access allowed");

class Admin extends BaseAdminController
{
	private $locale;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkLicensePremium();
		$lang = new MY_Lang();
		$lang->load("mod_seo");
		$this->load->model("seoexpert_model");
		$this->load->model("seoexpert_model_products");
		$this->load->library("form_validation");
		$this->locale = MY_Controller::defaultLocale();
		CMSFactory\assetManager::create()->setData("languages", $this->cms_admin->get_langs(true))->registerStyle("style")->registerScript("scripts");
	}

	public function index($locale = false)
	{
		if (!$locale) {
			$locale = $this->locale;
		}

		$baseSettings = mod_seo\classes\SeoHelper::create()->getBaseSettings($locale);
		$settings = $this->seoexpert_model->getSettings($locale);
		CMSFactory\assetManager::create()->setData("locale", $locale)->setData("baseSettings", $baseSettings)->setData("settings", $settings)->renderAdmin("main");
	}

	public function productsCategories($locale = NULL)
	{
		$locale = ($locale ? $locale : MY_Controller::defaultLocale());
		$categories = $this->seoexpert_model_products->getAllCategories($locale);
		CMSFactory\assetManager::create()->setData("categories", $categories)->renderAdmin("advanced/productsList");
	}

	public function productCategoryCreate($locale = false)
	{
		if (!$locale) {
			$locale = $this->locale;
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules("category_id", lang("Choose category", "mod_seo"), "required|numeric");

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$categoryId = $this->input->post("category_id");
				$categories = mod_seo\classes\SeoHelper::create()->prepareCategoriesForProductCategory($categoryId, $locale);
				$data = $this->input->post();

				foreach ((array) $categories as $key => $value ) {
					$data[$key] = $value;
				}

				unset($data["action"]);

				if ($this->seoexpert_model_products->setProductCategory($categoryId, $data, $locale) != false) {
					$this->lib_admin->log(lang("Seo category was created", "mod_seo") . " - " . $_POST["categoryNameTMP"]);
					showMessage(lang("Changes saved", "mod_seo"));
					pjax("/admin/components/init_window/mod_seo/productsCategories");
				}
				else {
					showMessage(lang("Can not create", "mod_seo"), "", "r");
				}
			}
		}
		else {
			CMSFactory\assetManager::create()->renderAdmin("advanced/productsCategoryCreate");
		}
	}

	public function productCategoryEdit($id = false, $locale = false)
	{
		if (!$id) {
			return false;
		}

		if (!$locale) {
			$locale = $this->locale;
		}

		$category = $this->seoexpert_model_products->getProductCategory($id, $this->locale);

		if (!empty($_POST)) {
			$this->form_validation->set_rules("category_id", lang("Category", "mod_seo"), "required|numeric");

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$categoryId = $this->input->post("category_id");
				$categories = mod_seo\classes\SeoHelper::create()->prepareCategoriesForProductCategory($categoryId, $locale);
				$data = $this->input->post();

				foreach ((array) $categories as $key => $value ) {
					$data[$key] = $value;
				}

				unset($data["action"]);

				if ($this->seoexpert_model_products->setProductCategory($categoryId, $data, $locale) != false) {
					$this->lib_admin->log(lang("Seo category was edited", "mod_seo") . " - " . $_POST["categoryNameTMP"]);
					showMessage(lang("Changes saved", "mod_seo"));
					$action = $_POST["action"];

					if ($action == "close") {
						pjax("/admin/components/init_window/mod_seo/productsCategories");
					}
				}
				else {
					showMessage(lang("Can not create", "mod_seo"), "", "r");
				}
			}
		}
		else {
			if (!$category) {
				$categoryDef = $this->seoexpert_model_products->getCategoryNameAndId($id);
			}

			CMSFactory\assetManager::create()->setData("locale", $locale)->setData("category", $category)->setData("categoryDef", $categoryDef)->renderAdmin("advanced/productsCategoryEdit");
		}
	}

	public function categoryAutocomplete()
	{
		mod_seo\classes\SeoHelper::create()->autoCompleteCategories();
	}

	public function save($locale = false)
	{
		$this->cache->delete_all();
		$baseSettings = $this->input->post("base");
		mod_seo\classes\SeoHelper::create()->setBaseSettings($locale, $baseSettings);
		$settings = $this->input->post();
		unset($settings["base"]);

		if ($this->seoexpert_model->setSettings($settings, $locale)) {
			$this->lib_admin->log(lang("Changes saved", "mod_seo") . " - " . lang("SEO expert", "mod_seo"));
			showMessage(lang("Changes saved", "mod_seo"));
		}

		$this->cache->delete_all();
	}

	public function ajaxDeleteProductCategories()
	{
		if (count($_POST["ids"]) < 1) {
			return false;
		}

		$this->db->select("settings");

		foreach ($_POST["ids"] as $val ) {
			$this->db->or_where("cat_id", $val);
		}

		$settings = $this->db->get("mod_seo_products")->result_array();
		$name = array();

		foreach ($settings as $val ) {
			$setting_value = unserialize($val["settings"]);
			$name[] = $setting_value["categoryNameTMP"];
		}

		foreach ($_POST["ids"] as $id ) {
			$this->seoexpert_model_products->deleteCategoryById($id);
		}

		$this->lib_admin->log(lang("Seo category was deleted", "mod_seo") . " - " . implode(", ", $name));
		showMessage(lang("Deleted complete", "admin"));
	}

	public function ajaxChangeActiveCategory()
	{
		$id = $this->input->post("id");

		if (!$id) {
			return false;
		}

		if ($this->seoexpert_model_products->changeActiveCategory($id)) {
			$this->db->select("settings");
			$this->db->where("cat_id", $id);
			$settings = $this->db->get("mod_seo_products")->result_array();
			$name = array();

			foreach ($settings as $val ) {
				$setting_value = unserialize($val["settings"]);
				$name[] = $setting_value["categoryNameTMP"];
			}

			$this->lib_admin->log(lang("Seo status category was changed", "mod_seo") . " - " . implode(", ", $name));
			echo "true";
		}
	}

	public function ajaxChangeEmptyMetaCategory()
	{
		$id = $this->input->post("id");

		if (!$id) {
			return false;
		}

		if ($this->seoexpert_model_products->changeEmptyMetaCategory($id)) {
			$this->db->select("settings");
			$this->db->where("cat_id", $id);
			$settings = $this->db->get("mod_seo_products")->result_array();
			$name = array();

			foreach ($settings as $val ) {
				$setting_value = unserialize($val["settings"]);
				$name[] = $setting_value["categoryNameTMP"];
			}

			$this->lib_admin->log(lang("Seo status empty meta category was changed", "mod_seo") . " - " . implode(", ", $name));
			echo "true";
		}
	}
}


?>
