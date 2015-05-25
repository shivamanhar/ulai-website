<?php

class ShopAdminBrands extends ShopAdminController
{
	protected $allowedImageExtensions = array("jpeg", "jpg", "png", "gif");
	public $imagePath = "./uploads/shop/brands/";
	public $defaultLanguage;
	protected $current_extension;
	protected $imageSizes = array("mainImageWidth" => 120, "mainImageHeight" => 61);
	protected $imageQuality = 99;
	protected $per_page = 10;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();

		if (!$_COOKIE["per_page"]) {
			setcookie("per_page", ShopCore::app()->SSettings->adminProductsPerPage, time() + 604800, "/", $_SERVER["HTTP_HOST"]);
			$this->per_page = ShopCore::app()->SSettings->adminProductsPerPage;
		}
		else {
			$this->per_page = $_COOKIE["per_page"];
		}
	}

	public function index($offset = 0)
	{
		$model = SBrandsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN);

		if (!empty(ShopCore::$_GET["brand_name"])) {
			$model->where("SBrandsI18n.Name LIKE ?", "%" . ShopCore::$_GET["brand_name"] . "%");
		}

		if (!empty(ShopCore::$_GET["brand_id"])) {
			$model->filterById(ShopCore::$_GET["brand_id"]);
		}

		$PaginationModel = clone $model;
		$model = $model->distinct()->orderByID(Propel\Runtime\ActiveQuery\Criteria::DESC)->limit($this->per_page)->offset(ShopCore::$_GET["per_page"])->find();
		$total = $PaginationModel->count();
		$this->load->library("pagination");
		$config["base_url"] = "/admin/components/run/shop/brands/index/?" . http_build_query(ShopCore::$_GET);
		$config["container"] = "shopAdminPage";
		$config["page_query_string"] = true;
		$config["uri_segment"] = 8;
		$config["total_rows"] = $total;
		$config["per_page"] = $this->per_page;
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
		$this->render("list", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "pagination" => $this->pagination->create_links_ajax(), "total" => $total));
	}

	public function create()
	{
		$locale = MY_Controller::getCurrentLocale();
		CMSFactory\Events::create()->registerEvent("", "ShopAdminBrands:preCreate");
		CMSFactory\Events::runFactory();
		$model = new SBrands();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$url = (string) $this->input->post("Url");

				if ($url == "") {
					$this->load->helper("translit");
					$url = translit_url($this->input->post("Name"));
				}

				$UrlCheck = SBrandsQuery::create()->where("SBrands.Url = ?", $url)->findOne();

				if ($UrlCheck !== NULL) {
					exit(showMessage(lang("This URL is already in use", "admin"), "", "r"));
				}

				$model->fromArray($_POST);
				$model->setCreated(time());
				$model->setUpdated(time());
				$model->save();
				$model->setPosition($model->getId());
				$model->save();
				$this->load->library("image_lib");

				if (!empty($_FILES) && ($this->_isAllowedExtension($_FILES["mainPhoto"]["name"]) !== true)) {
					showMessage(lang("Wrong image format"), "", "r");
				}

				if (!empty($_FILES["mainPhoto"]["tmp_name"]) && ($this->_isAllowedExtension($_FILES["mainPhoto"]["name"]) === true)) {
					$imageSizes = $this->getImageSize($_FILES["mainPhoto"]["tmp_name"]);
					$imageName = $model->getUrl() . "." . $this->current_extension;
					if (($this->imageSizes["mainImageWidth"] <= $imageSizes["width"]) || ($this->imageSizes["mainImageHeight"] <= $imageSizes["height"])) {
						$config["image_library"] = "gd2";
						$config["source_image"] = $_FILES["mainPhoto"]["tmp_name"];
						$config["create_thumb"] = false;
						$config["maintain_ratio"] = true;
						$config["width"] = $this->imageSizes["mainImageWidth"];
						$config["height"] = $this->imageSizes["mainImageHeight"];
						$config["master_dim"] = "height";
						$config["new_image"] = ShopCore::$imagesUploadPath . "brands/" . $imageName;
						$config["quality"] = $this->imageQuality;
						$this->image_lib->initialize($config);

						if ($this->image_lib->resize()) {
							$mainImageResized = true;
							$model->setImage($imageName);
						}
					}
					else {
						move_uploaded_file($_FILES["mainPhoto"]["tmp_name"], ShopCore::$imagesUploadPath . "brands/" . $imageName);
						$mainImageResized = true;
						$model->setImage($imageName);
					}

					$model->save();
				}

				CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id()));
				CMSFactory\Events::runFactory();
				$this->lib_admin->log(lang("Brand created", "admin") . ". Id: " . $model->getId());
				showMessage(lang("Brand created", "admin"));
				$action = $_POST["action"];

				if ($action == "exit") {
					pjax("/admin/components/run/shop/brands/index");
				}
				else if ($action === "fast_brand_create") {
					pjax("/admin/components/run/shop/brands/index?fast_create=on");
				}
				else {
					pjax("/admin/components/run/shop/brands/edit/" . $model->getId() . "/" . $locale);
				}
			}
		}
		else {
			$this->render("create", array("model" => $model, "locale" => $locale));
		}
	}

	public function edit($brandId = NULL, $locale = NULL)
	{
		$locale = ($locale == NULL ? MY_Controller::getCurrentLocale() : $locale);
		$model = SBrandsQuery::create()->findPk((int) $brandId);

		if ($model === NULL) {
			$this->error404(lang("Brand not found", "admin"), "", "r");
		}

		CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id(), "url" => $model->getUrl()), "ShopAdminBrands:preEdit");
		CMSFactory\Events::runFactory();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$url = (string) $this->input->post("Url");

				if ($url == "") {
					$this->load->helper("translit");
					$url = translit_url($this->input->post("Name"));
				}

				$UrlCheck = SBrandsQuery::create()->where("SBrands.Url = ?", $url)->where("SBrands.Id != ?", (int) $model->getId())->findOne();

				if ($UrlCheck !== NULL) {
					exit(showMessage(lang("This URL is already in use", "admin"), "", "r"));
				}

				$_POST["Locale"] = $locale;
				$model->fromArray($_POST);
				$model->setUpdated(time());

				if ($this->input->post("deleteImage") == 1) {
					$this->deleteImage($model);
					$model->setImage(" ");
				}

				$model->save();
				$this->load->library("image_lib");

				if (isset($_FILES["mainPhoto"])) {
					if ($this->_isAllowedExtension($_FILES["mainPhoto"]["name"]) !== true) {
						showMessage(lang("Wrong image format"), "", "r");
					}
				}

				if (!empty($_FILES["mainPhoto"]["tmp_name"]) && ($this->_isAllowedExtension($_FILES["mainPhoto"]["name"]) === true)) {
					$imageSizes = $this->getImageSize($_FILES["mainPhoto"]["tmp_name"]);
					$imageName = $model->getUrl() . "." . $this->current_extension;
					if (($this->imageSizes["mainImageWidth"] <= $imageSizes["width"]) || ($this->imageSizes["mainImageHeight"] <= $imageSizes["height"])) {
						$config["image_library"] = "gd2";
						$config["source_image"] = $_FILES["mainPhoto"]["tmp_name"];
						$config["create_thumb"] = false;
						$config["maintain_ratio"] = true;
						$config["width"] = $this->imageSizes["mainImageWidth"];
						$config["height"] = $this->imageSizes["mainImageHeight"];
						$config["master_dim"] = "height";
						$config["new_image"] = ShopCore::$imagesUploadPath . "brands/" . $imageName;
						$config["quality"] = $this->imageQuality;
						$this->image_lib->initialize($config);

						if ($this->image_lib->resize()) {
							$mainImageResized = true;
							$model->setImage($imageName);
						}
					}
					else {
						move_uploaded_file($_FILES["mainPhoto"]["tmp_name"], ShopCore::$imagesUploadPath . "brands/" . $imageName);
						$mainImageResized = true;
						$model->setImage($imageName);
					}

					$model->save();
				}

				CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id(), "url" => $model->getUrl()));
				CMSFactory\Events::runFactory();
				$this->lib_admin->log(lang("Brand edited", "admin") . ". Id: " . $brandId);
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/brands/index");
				}

				if ($_POST["action"] == "toedit") {
					pjax("/admin/components/run/shop/brands/edit/" . $model->getId());
				}

				if ($_POST["action"] == "tocreate") {
					pjax("/admin/components/run/shop/brands/create");
				}
			}
		}
		else {
			$model->setLocale($locale);
			$brandName = $model->getName();

			if (empty($brandName)) {
				$brandName = CI::$APP->db->select("name")->limit(1)->get_where("shop_brands_i18n", array("id" => $brandId, "locale" => $locale))->row()->name;
			}

			$this->render("edit", array("brandName" => $brandName, "model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "locale" => $locale));
		}
	}

	public function delete()
	{
		$id = $_POST["ids"];

		foreach ($id as $item ) {
			$item = (int) $item;
		}

		$model = SBrandsQuery::create()->findPks($id);

		if ($model != NULL) {
			$this->deleteImage($model);
			$model->delete();
			CMSFactory\Events::create()->registerEvent(array("brandId" => $id, "userId" => $this->dx_auth->get_user_id()));
			CMSFactory\Events::runFactory();
			$this->lib_admin->log(lang("Brand (s) has been successfully removed (s)", "admin") . ". Ids: " . implode(", ", $id));
			showMessage(lang("Brand (s) has been successfully removed (s)", "admin"));
			pjax("/admin/components/run/shop/brands/index");
		}
	}

	public function c_list()
	{
		$model = SBrandsQuery::create()->orderByPosition()->useI18nQuery($this->defaultLanguage["identif"])->endUse()->find();
		$this->render("list", array("model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true)));
	}

	public function deleteImage($model = NULL)
	{
		if (!$model) {
			return false;
		}

		if ($model instanceof SBrands) {
			$model = array($model);
		}

		foreach ($model as $brand ) {
			$name = $brand->getImage();

			if ($name) {
				$image_path = $this->imagePath . $name;

				if (file_exists($image_path)) {
					unlink($image_path);
				}
			}
		}

		return true;
	}

	protected function _isAllowedExtension($fileName)
	{
		$parts = explode(".", $fileName);
		$ext = strtolower(end($parts));
		$this->current_extension = $ext;

		if (in_array($ext, $this->allowedImageExtensions)) {
			return true;
		}

		return false;
	}

	protected function getImageSize($file_path)
	{
		if (function_exists("getimagesize") && file_exists($file_path)) {
			$image = @getimagesize($file_path);
			$size = array("width" => $image[0], "height" => $image[1]);
			return $size;
		}

		return false;
	}

	public function translate($id)
	{
		$model = SBrandsQuery::create()->findPk((int) $id);

		if ($model === NULL) {
			$this->error404(lang("Brand not found", "admin"));
		}

		$languages = ShopCore::$ci->cms_admin->get_langs(true);
		$translatableFieldNames = $model->getTranslatableFieldNames();

		if (!empty($_POST)) {
			$translatingRules = $model->translatingRules();

			foreach ($languages as $language ) {
				foreach ($translatableFieldNames as $fieldName ) {
					$this->form_validation->set_rules($fieldName . "_" . $language["identif"], $model->getLabel($fieldName) . lang(" language ", "admin") . $language["lang_name"], $translatingRules[$fieldName]);
				}
			}

			if ($this->form_validation->run() == false) {
				showMessage(validation_errors());
			}
			else {
				foreach ($languages as $language ) {
					$model->setLocale($language["identif"]);

					foreach ($translatableFieldNames as $fieldName ) {
						$methodName = "set" . $fieldName;
						$model->$methodName($this->input->post($fieldName . "_" . $language["identif"]));
					}
				}

				$model->save();
				showMessage(lang("Changes have been saved", "admin"));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/brands/index");
				}

				if ($_POST["action"] == "toedit") {
					pjax("/admin/components/run/shop/brands/edit/" . $model->getId());
				}

				if ($_POST["action"] == "tocreate") {
					pjax("/admin/components/run/shop/brands/create");
				}
			}
		}
		else {
			$mceEditorFieldNames = array("Description");
			$requairedFieldNames = array("Name");
			$this->render("translate", array("model" => $model, "languages" => $languages, "translatableFieldNames" => $translatableFieldNames, "mceEditorFieldNames" => $mceEditorFieldNames, "requairedFieldNames" => $requairedFieldNames));
		}
	}

	public function save_positions()
	{
		$positions = $_POST["positions"];

		if (sizeof($positions) == 0) {
			return false;
		}

		foreach ($positions as $key => $val ) {
			$query = "UPDATE `shop_brands` SET `position`=" . $key . " WHERE `id`=" . (int) $val . "; ";
			$this->db->query($query);
		}

		showMessage(lang("Positions saved", "admin"));
	}
}


?>
