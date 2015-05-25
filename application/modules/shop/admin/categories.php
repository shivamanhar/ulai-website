<?php

class ShopAdminCategories extends ShopAdminController
{
	public $defaultLanguage;
	public $catProductsCounts = array();
	public $tree = false;
	private $templatePath;
	private $all_cat = array();
	private $ext_cat = array();
	private $prod_count = array();
	private $categoryApi;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
		$this->templatePath = ShopCore::app()->SSettings->__get("systemTemplatePath");
		$this->templatePath = str_replace("./", "", $this->templatePath) . "/";
		$this->categoryApi = Category\CategoryApi::getInstance();
	}

	public function index($id = NULL)
	{
		$this->tree = $this->categoryApi->getTree();
		$this->render("list", array("tree" => $this->tree, "htmlTree" => $this->printCategoryTree(), "languages" => ShopCore::$ci->cms_admin->get_langs(true)));
	}

	public function load_all_cat()
	{
		$this->all_cat = $this->db->get("shop_category");

		if (0 < $this->all_cat->num_rows()) {
			$this->all_cat = $this->all_cat->result_array();
		}
		else {
			$this->all_cat = array();
		}

		return $this->all_cat;
	}

	public function load_count_prod()
	{
		$sql = "SELECT count(category_id) as prod_count, category_id FROM `shop_products` group by category_id";
		$res = $this->db->query($sql);

		if (0 < $res->num_rows()) {
			foreach ($res->result_array() as $r ) {
				$this->prod_count[$r["category_id"]] = $r["prod_count"];
			}
		}
	}

	public function ext_cat()
	{
		  if (count($this->all_cat) > 0) {
            foreach ($this->all_cat as $cat)
                $this->ext_cat[$cat['id']] = $cat;
            foreach ($this->ext_cat as $key => $cat) {
                foreach ($this->ext_cat as $cat_parent)
                    if ($cat['id'] == $cat_parent['parent_id']) {
                        $this->ext_cat[$key]['has_child'] = true;
                        break;
                    }
                $this->ext_cat[$key]['prod_count'] = $this->prod_count[$key];
            }
        }
	}


	public function create()
	{
		$model = new SCategory();
		CMSFactory\Events::create()->registerEvent("", "ShopAdminCategories:preCreate");
		CMSFactory\Events::runFactory();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run() == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$locale = MY_Controller::getCurrentLocale();
				$postData = $this->input->post();
				$data = array("tpl" => $postData["tpl"], "order_method" => $postData["order_method"], "showsitetitle" => $postData["showsitetitle"], "parent_id" => $postData["ParentId"], "url" => $postData["Url"], "active" => (int) $postData["Active"], "image" => $postData["Image"], "name" => $postData["Name"], "h1" => $postData["H1"], "description" => $postData["Description"], "meta_desc" => $postData["MetaDesc"], "meta_title" => $postData["MetaTitle"], "meta_keywords" => $postData["MetaKeywords"], "position" => NULL, "external_id" => NULL, "created" => time(), "updated" => time());
				$model = $this->categoryApi->addCategory($data, $locale);

				if ($this->categoryApi->getError()) {
					showMessage($this->categoryApi->getError(), "", "r");
					exit();
				}

				$CI = &get_instance();
				$sitemap = $CI->db->get_where("components", array("name" => "sitemap"));

				if (0 < $sitemap->num_rows()) {
					$CI->load->module("sitemap")->ping_google($this);
				}

				CMSFactory\Events::create()->registerEvent(array("ShopCategoryId" => $model->getId()))->runFactory();
				$ShopCategoryId = $this->db->order_by("id", "desc")->get("shop_category")->row()->id;
				$this->lib_admin->log(lang("Category created", "admin") . ". Id: " . $ShopCategoryId);
				showMessage(lang("Category created", "admin"));

				if ($postData["action"] == "close") {
					pjax("/admin/components/run/shop/categories/index");
				}

				if ($postData["action"] == "edit") {
					pjax("/admin/components/run/shop/categories/edit/" . $model->getId() . "/" . $locale);
				}

				$this->cache->clearCacheFolder("category");
			}
		}
		else {
			$this->render("create", array("model" => $model, "categories" => $this->categoryApi->getTree(false), "tpls" => $this->get_tpl_names($this->templatePath)));
		}
	}

	public function createCatFast()
	{
		if ($_POST) {
			$model = new SCategory();
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run() === false) {
				echo json_encode(array("error" => 1, "data" => validation_errors()));
				exit();
			}
			else {
				$locale = MY_Controller::getCurrentLocale();
				$postData = $this->input->post();
				$data = array("parent_id" => (int) $postData["catId"], "url" => $postData["url"], "active" => (int) $postData["active"], "name" => $postData["Name"], "created" => time(), "updated" => time());
				$model = $this->categoryApi->addCategory($data, $locale);
				$model->setPosition(-$model->getId());
				$model->save();

				if ($this->categoryApi->getError()) {
					echo json_encode(array("error" => 1, "data" => $this->categoryApi->getError()));
					exit();
				}

				echo json_encode(array("error" => 0, "data" => lang("Category created", "admin")));
			}
		}
	}

	public function edit($id = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? $this->defaultLanguage["identif"] : $locale);
		$currentLocale = MY_Controller::getCurrentLocale();
		$model = SCategoryQuery::create()->joinWithI18n($currentLocale)->findPk((int) $id);
		CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id(), "url" => $model->getUrl()), "ShopAdminCategories:preEdit");
		CMSFactory\Events::runFactory();

		if ($model === NULL) {
			$this->error404(lang("Category not found", "admin"));
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run() == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$postData = $this->input->post();
				$data = array("tpl" => $postData["tpl"], "order_method" => $postData["order_method"], "showsitetitle" => $postData["showsitetitle"], "parent_id" => $postData["ParentId"], "url" => $postData["Url"], "active" => (int) $postData["Active"], "image" => $postData["Image"], "name" => $postData["Name"], "h1" => $postData["H1"], "description" => $postData["Description"], "meta_desc" => $postData["MetaDesc"], "meta_title" => $postData["MetaTitle"], "meta_keywords" => $postData["MetaKeywords"], "updated" => time());
				$model = $this->categoryApi->updateCategory($id, $data, $locale);

				if ($this->categoryApi->getError()) {
					showMessage($this->categoryApi->getError(), "", "r");
					exit();
				}

				CMSFactory\Events::create()->registerEvent(array("ShopCategoryId" => $model->getId(), "url" => $model->getUrl()))->runFactory();
				$this->lib_admin->log(lang("Category edited", "admin") . ". Id: " . $id);
				showMessage(lang("Changes saved", "admin"));

				if ($postData["action"] == "close") {
					pjax("/admin/components/run/shop/categories/index");
				}

				if ($postData["action"] == "edit") {
					pjax("/admin/components/run/shop/categories/edit/" . $model->getId() . "/" . $locale);
				}

				$this->cache->clearCacheFolder("category");
			}
		}
		else {
			$model->setLocale($locale);
			$this->load->helper("cookie");
			set_cookie("category_full_path_ids", json_encode(unserialize($model->getFullPathIds())), 60 * 60 * 60);
			$this->render("edit", array("model" => $model, "modelArray" => $model->toArray(), "categories" => $this->categoryApi->getTree(false), "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale, "tpls" => $this->get_tpl_names($this->templatePath)));
			exit();
		}
	}

	public function delete()
	{
		$category_id = $this->input->post("id");
		CMSFactory\Events::create()->registerEvent(array("ShopCategoryId" => $this->input->post("id")))->runFactory();

		if ($category_id) {
			$result = $this->categoryApi->deleteCategory($category_id);

			if (!$result) {
				showMessage(lang("Failed to delete the category", "admin"), "", "r");
				showMessage($this->categoryApi->getError(), "", "r");
			}
			else {
				$this->lib_admin->log(lang("Category deleted", "admin") . ". Ids: " . implode(", ", $category_id));
				showMessage(lang("Category deleted successfully", "admin"));
				$this->cache->clearCacheFolder("category");
			}
		}
		else {
			showMessage(lang("Failed to delete the category", "admin"));
		}

		$CI = &get_instance();

		if ($CI->db->get_where("components", array("name" => "sitemap"))->row()) {
			$CI->load->module("sitemap")->ping_google($this);
		}
	}

	private function printCategoryTree($ajax_tree = false)
	{
		$this->load_all_cat();
		$this->load_count_prod();
		$this->ext_cat();

		if (!$ajax_tree) {
			if (!$this->tree) {
				$tree = $this->categoryApi->getTree();
			}
			else {
				$tree = $this->tree;
			}
		}
		else {
			$tree = $ajax_tree;
		}

		$output = "";

		if (!$ajax_tree) {
			$output .= "<div class=\"sortable save_positions\" data-url=\"/admin/components/run/shop/categories/save_positions\">";
		}
		else {
			$output .= "<div class=\"frame_level sortable\" style=\"display: block\" data-url=\"/admin/components/run/shop/categories/save_positions\">";
		}

		if (!$ajax_tree) {
			foreach ($tree as $c ) {
				if ($c->getParentId() == 0) {
					$output .= $this->printCategory($c);
				}
			}
		}
		else {
			foreach ($tree as $c ) {
				$output .= $this->printCategory($c);
			}
		}

		$output .= "</div>";

		if (!$ajax_tree) {
			return $output;
		}

		echo $output;
	}

	private function printCategory($category)
	{
		$PrintCategory = new stdClass();

		if (is_object($category)) {
			$name = ($category->getName() ? $category->getName() : lang("Тo translation", "admin") . " (" . MY_Controller::getCurrentLocale() . ")");
			$PrintCategory->id = $category->getId();
			$PrintCategory->parent = ($category->getSCategory() != NULL ? $category->getSCategory()->getName() : "-");
			$PrintCategory->name = $name;
			$PrintCategory->url = $category->getFullPath();
			$PrintCategory->active = $category->getActive();
			$level = count(explode("/", $PrintCategory->url));
			$PrintCategory->level = $level;
		}
		else {
			$getSCategory = SCategoryQuery::create()->filterById($category["id"])->findOne();
			$name = ($category["name"] ? $category["name"] : lang("Тo translation", "admin") . " (" . MY_Controller::getCurrentLocale() . ")");
			$PrintCategory->parent = ($getSCategory->getSCategory() ? $getSCategory->getSCategory()->getName() : "-");
			$PrintCategory->id = $category["id"];
			$PrintCategory->name = $name;
			$PrintCategory->url = $category["full_path"];
			$PrintCategory->active = $category["active"];
			$level = count(explode("/", $category["full_path"]));
			$PrintCategory->level = $level;
		}

		$PrintCategory->hasChilds = (bool) $this->ext_cat[$PrintCategory->id]["has_child"];
		$PrintCategory->myProdCnt = (int) $this->ext_cat[$PrintCategory->id]["prod_count"];
		$output .= "<div>";
		$this->template->assign("cat", $PrintCategory);
		$output .= $this->template->fetch("file:" . $this->getViewFullPath("_listItem"));
		$output .= "</div>";
		unset($PrintCategory);
		return $output;
	}

	public function ajax_load_parent()
	{
		$id = (int) $_POST["id"];
		$locale = MY_Controller::getCurrentLocale();
		$ajax_load_parent = CI::$APP->db->join("shop_category_i18n", "shop_category_i18n.id=shop_category.id AND shop_category_i18n.locale='$locale'")->where("parent_id", $id)->order_by("position", "asc")->get("shop_category")->result_array();
		$this->printCategoryTree($ajax_load_parent);
	}

	public function save_positions()
	{
		$result = CI::$APP->db->select(array("parent_id", "position"))->get_where("shop_category", array("id" => (int) $_POST["categoryId"]))->row_array();
		$this->categories2 = CI::$APP->db->select(array("id", "parent_id", "position"))->order_by("position", "asc")->get("shop_category")->result_array();
		$CountCategories = count($this->categories2);
		$CategoriesArray = array();

		foreach ($_POST["positions"] as $categoryId ) {
			foreach ($this->categories2 as $CatItem ) {
				if (($CatItem["id"] == $categoryId) && ($result["parent_id"] == $CatItem["parent_id"])) {
					$CategoriesArray[$CatItem["id"]] = $this->getChildsRecursive($CatItem["id"]);
					$CountCategories = ($CatItem["position"] < $CountCategories ? $CatItem["position"] : $CountCategories);
					break;
				}
			}
		}

		$positions = array();

		foreach ($CategoriesArray as $categoryId => $childs ) {
			$positions[] = array("id" => $categoryId, "position" => $CountCategories++);

			foreach ($childs as $key => $SubItem ) {
				$positions[] = array("id" => $key, "position" => $CountCategories++);
			}
		}

		CI::$APP->db->update_batch("shop_category", $positions, "id");
		showMessage(lang("Positions saved", "admin"));
		$this->cache->clearCacheFolder("category");
	}

	private function getChildsRecursive($categoryId)
	{
		$ChildCat = array();

		foreach ($this->categories2 as $CatItem ) {
			if ($categoryId == $CatItem["parent_id"]) {
				$ChildCat[$CatItem["id"]] = $CatItem["position"];
				$ChildCatSub = $this->getChildsRecursive($CatItem["id"]);

				if (0 < count($ChildCatSub)) {
					foreach ($ChildCatSub as $key => $ChildCatSubItem ) {
						$ChildCat[$key] = $ChildCatSubItem;
					}
				}
			}
		}

		return $ChildCat;
	}

	public function ajax_translit()
	{
		$this->load->helper("translit");
		$str = $this->input->post("str");
		echo translit_url($str);
	}

	public function changeActive()
	{
		$id = $this->input->post("id");
		$model = SCategoryQuery::create()->findPk($id);

		if (0 < count($model)) {
			$model->setActive(!$model->getActive());

			if ($model->save()) {
				$message = ($model->getActive() ? lang("Category activated.", "admin") : lang("Category deactivated.", "admin")) . " " . lang("Category ID:") . " " . $id;
				$this->lib_admin->log($message);
				showMessage(lang("Changes saved", "admin"));
			}

			$this->cache->clearCacheFolder("category");
		}
	}

	public function create_tpl()
	{
		$file = trim($this->input->post("filename"));
		$this->form_validation->set_rules("filename", lang("Template name", "admin"), "required|alpha_numeric|min_length[1]|max_length[250]");

		if ($this->form_validation->run() == false) {
			$responce = showMessage(validation_errors(), "", "r", true);
			$result = false;
			echo json_encode(array("responce" => $responce, "result" => $result));
			return false;
		}

		$file = $this->templatePath . $file . ".tpl";

		if (!file_exists($file)) {
			$fp = fopen($file, "w");

			if ($fp) {
				$responce = showMessage(lang("The file has been successfully created", "admin"), "", "", true);
				$result = true;
			}
			else {
				$responce = showMessage(lang("Could not create file", "admin"), "", "r", true);
				$result = false;
			}

			fwrite($fp, "/* new ImageCMS Tpl file */");
			fclose($fp);
			echo json_encode(array("responce" => $responce, "result" => $result));
		}
		else {
			$responce = showMessage(lang("File with the same name is already exist."), "", "r", true);
			$result = false;
			echo json_encode(array("responce" => $responce, "result" => $result));
			return false;
		}
	}

	public function get_tpl_names($directory)
	{
		$arr = scandir($directory);

		foreach ($arr as $item ) {
			if (is_file($directory . "/" . $item)) {
				$a = explode(".", $item);

				if ($a[1] == "tpl") {
					$result[] = str_replace(".tpl", "", $item);
				}
			}
		}

		return $result;
	}
}


?>
