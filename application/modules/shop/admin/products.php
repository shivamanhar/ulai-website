<?php

class ShopAdminProducts extends ShopAdminController
{
	protected $per_page = 20;
	protected $allowedImageExtensions = array("jpg", "png", "gif", "jpeg");
	public $defaultLanguage;
	protected $imageSizes = array();
	protected $imageQuality = 99;

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->per_page = ShopCore::app()->SSettings->adminProductsPerPage;
		$this->load->helper("url");
		$this->load->library("upload");
		$this->load->helper("translit");
		$this->defaultLanguage = getDefaultLanguage();
	}

	public function ajax_translit()
	{
		$this->load->helper("translit");
		$str = $this->input->post("str");
		echo translit_url($str);
	}

	public function index($categoryID = NULL, $offset = 0, $orderField = "", $orderCriteria = "")
	{
		$model = SCategoryQuery::create()->findPk((int) $categoryID);

		if ($model === NULL) {
			$this->error404(lang("Category not found", "admin"));
		}

		$products = SProductsQuery::create()->filterByCategory($model);
		$totalProducts = clone $products;
		$totalProducts = $totalProducts->count();
		$products = $products->limit($this->per_page)->offset((int) $offset);
		$nextOrderCriteria = "";

		if (($orderCriteria !== "") && method_exists($products, "filterBy" . $orderField)) {
			switch ($orderCriteria) {
			case "ASC":
				$products = ($orderField != "Price" ? $products->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::ASC) : $products->leftJoin("ProductVariant")->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::ASC));
				$nextOrderCriteria = "DESC";
			case "DESC":
				$products = ($orderField != "Price" ? $products->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::DESC) : $products->leftJoin("ProductVariant")->orderBy($orderField, Propel\Runtime\ActiveQuery\Criteria::DESC));
				$nextOrderCriteria = "ASC";
			}
		}
		else {
			$products->orderById('desc');

		}

		$products = $products->find();
		$products->populateRelation("ProductVariant");
		$this->load->library("pagination");
		$config["base_url"] = $this->createUrl("products/index/", array("catId" => $model->getId()));
		$config["container"] = "shopAdminPage";
		$config["uri_segment"] = 8;
		$config["total_rows"] = $totalProducts;
		$config["per_page"] = $this->per_page;
		$config["suffix"] = ($orderField != "" ? $orderField . "/" . $orderCriteria : "");
		$this->pagination->num_links = 6;
		$this->pagination->initialize($config);
		$this->render("list", array("model" => $model, "products" => $products, "totalProducts" => $totalProducts, "pagination" => $this->pagination->create_links_ajax(), "category" => SCategoryQuery::create()->findPk((int) $categoryID), "nextOrderCriteria" => $nextOrderCriteria, "orderField" => $orderField, "locale" => $this->defaultLanguage["identif"]));
	}

	public function tpl_validation($tpl)
	{
		if (preg_match("/^[A-Za-z\_\.]{0,50}$/", $tpl)) {
			return true;
		}

		$this->form_validation->set_message("tpl_validation", lang("The %s field can only contain Latin characters", "admin"));
		return false;
	}

	public function create()
	{
		$model = new SProducts();
		$locale = MY_Controller::getCurrentLocale();
		CMSFactory\Events::create()->registerEvent("", "ShopAdminProducts:preCreate");
		CMSFactory\Events::runFactory();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());
			$validation = $this->form_validation->set_rules("Created", lang("Date Created", "admin"), "required|valid_date");
			$validation = $model->validateCustomData($validation);

			if ($validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$images = $this->upload_all();
				$datas = $this->input->post();
				$data = array("product_name" => $datas["Name"], "active" => $datas["Active"], "variant_name" => $datas["variants"]["Name"][0], "price_in_main" => $datas["variants"]["PriceInMain"][0], "currency" => $datas["variants"]["currency"][0], "number" => $datas["variants"]["Number"][0], "stock" => $datas["variants"]["Stock"][0], "brand_id" => $datas["BrandId"], "category_id" => $datas["CategoryId"], "additional_categories_ids" => $datas["Categories"] ? $datas["Categories"] : array(), "short_description" => $datas["ShortDescription"], "full_description" => $datas["FullDescription"], "old_price" => $datas["OldPrice"], "tpl" => $datas["tpl"], "url" => $datas["Url"], "meta_title" => $datas["MetaTitle"], "meta_description" => $datas["MetaDescription"], "meta_keywords" => $datas["MetaKeywords"], "related_products" => $datas["RelatedProducts"], "enable_comments" => $datas["EnableComments"], "created" => $datas["Created"] ? strtotime($datas["Created"]) : "", "updated" => time(), "hit" => $datas["hit"], "hot" => $datas["hot"], "action" => $datas["actions"]);

				if ($datas["changeImage"][0]) {
					$data["mainImage"] = ($images["image0"] ? $images["image0"] : "");
				}
				elseif ($datas["variants"]["inetImage"][0]) {
					$p_images = MediaManager\GetImages::create()->saveImage($datas["variants"]["inetImage"][0]);
					$images["image0"] = $p_images;
					$data["mainImage"] = $p_images;
				}


				$model = Products\ProductApi::getInstance()->addProduct($data, $locale);

				if (Products\ProductApi::getInstance()->getError()) {
					showMessage(Products\ProductApi::getInstance()->getError(), "", "r");
					exit();
				}

				if (1 < count($datas["variants"]["PriceInMain"])) {
					$i = 1;

				while ($i < count($datas["variants"]["PriceInMain"])) {
						$p_price = array("number" => $datas["variants"]["Number"][$i], "stock" => $datas["variants"]["Stock"][$i], "currency" => $datas["variants"]["currency"][$i], "price_in_main" => $datas["variants"]["PriceInMain"][$i], "position" => $i, "variant_name" => $datas["variants"]["Name"][$i]);

						if ($datas["changeImage"][$i]) {
							$p_price["mainImage"] = ($images["image" . $i] ? $images["image" . $i] : "");
						}
						else if ($datas["variants"]["inetImage"][$i]) {
							$p_images = MediaManager\GetImages::create()->saveImage($datas["variants"]["inetImage"][$i]);
							$images["image" . $i] = $p_images;
							$p_price["mainImage"] = $p_images;
						}

						Products\ProductApi::getInstance()->addVariant($model->getId(), $p_price);
						++$i;
					}
				}


				MediaManager\Image::create()->checkOriginFolder();
				MediaManager\Image::create()->checkImagesFolders();
				MediaManager\Image::create()->checkWatermarks();
				MediaManager\Image::create()->resizeByName($images);
				CMSFactory\Events::create()->registerEvent(array("model" => $model, "productId" => $model->getId(), "userId" => $this->dx_auth->get_user_id()));
				CMSFactory\Events::runFactory();
				$prodicts_list = $this->db->order_by("id", "desc")->get("shop_products")->row()->id;
				$this->lib_admin->log(lang("The product was created", "admin") . ". Id: " . $prodicts_list);
				showMessage(lang("The product was successfully created", "admin"));

				if ($_POST["action"] == "close") {
					pjax("/admin/components/run/shop/search/index");
				}
				else {
					pjax("/admin/components/run/shop/products/edit/" . $model->getId());
				}
			}
		}
		else {
			$brands = SBrandsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderById();
			$offset = 0;
			$per_page = 10000;
			$brands = $brands->distinct()->limit($per_page)->offset((int) $offset)->find();
			$currencies = SCurrenciesQuery::create()->find();
			$this->render("create", array("brands" => $brands, "model" => $model, "categories" => ShopCore::app()->SCategoryTree->getTree_(), "cur_date" => date("Y-m-d H:i:s"), "warehouses" => SWarehousesQuery::create()->orderByName()->find(), "locale" => $locale, "currencies" => $currencies, "imagesPopup" => $this->render("images", array(), true)));
		}
	}

	public function fastProdCreate()
	{
		if ($_POST) {
			$model = new SProducts();
			$rule = array(
				array("field" => "Name", "label" => $model->getLabel("Name"), "rules" => "required"),
				array("field" => "price", "label" => $model->getLabel("Price"), "rules" => "trim|required|numeric"),
				array("field" => "CategoryId", "label" => $model->getLabel("CategoryId"), "rules" => "required|integer")
				);
			$this->form_validation->set_rules($rule);

			if ($this->form_validation->run()) {
				$locale = MY_Controller::getCurrentLocale();

				if ($_FILES["mainPhoto"]) {
					$config["upload_path"] = "./uploads/shop/products/origin";
					$config["allowed_types"] = "gif|jpg|jpeg|png";
					$config["encrypt_name"] = true;
					$this->upload->initialize($config);

					if (!$this->upload->do_upload("mainPhoto")) {
						echo json_encode(array("error" => 1, "data" => $this->upload->display_errors()));
						exit();
					}
					else {
						$result = array("upload_data" => $this->upload->data());
					}
				}

				$data = array("active" => (int) $this->input->post("active"), "hit" => (int) $this->input->post("hit"), "action" => (int) $this->input->post("action"), "price_in_main" => str_replace(",", ".", (double) $this->input->post("price")), "hot" => (int) $this->input->post("hot"), "category_id" => $this->input->post("CategoryId"), "brand_id" => 0, "url" => translit_url($this->input->post("Name")), "created" => time(), "product_name" => $this->input->post("Name"), "enable_comments" => "1", "stock" => 1, "number" => $this->input->post("number"), "currency" => Currency\Currency::create()->default->getId());
				$data["mainImage"] = ($result["upload_data"]["file_name"] ? $result["upload_data"]["file_name"] : "");
				$model = Products\ProductApi::getInstance()->addProduct($data, $locale);

				if (Products\ProductApi::getInstance()->getError()) {
					echo json_encode(array("error" => 1, "data" => Products\ProductApi::getInstance()->getError()));
					exit();
				}

				MediaManager\Image::create()->checkOriginFolder();
				MediaManager\Image::create()->checkImagesFolders();
				MediaManager\Image::create()->checkWatermarks();
				MediaManager\Image::create()->resizeByName(array($data["mainImage"]));
				$ProductListItem = $this->render("oneProductListItem", array("model" => $model), true);
				$_renderer = $this->render("fastCreateForm", array("show_fast_form" => true), true);
				echo json_encode(array("error" => 0, "data" => lang("The product was successfully created", "admin"), "viewOneProduct" => $ProductListItem, "viewFastCreateForm" => $_renderer));
			}
			else {
				echo json_encode(array("error" => 1, "data" => validation_errors()));
			}
		}
	}

	public function get_images($type)
	{
		$url = trim($_POST["q"]);

		switch ($type) {
            case "search":
                $images = \MediaManager\GetImages::create()->searchImages($url, (int) $_POST['pos']);
                echo json_encode($images);
                break;
            case "url":
                $image = \MediaManager\GetImages::create()->getImage($url);
                $url1 = $image === FALSE ? '0' : $url;
                echo json_encode(array('url' => $url1));
                break;
        }

	}

	public function save_image()
	{
		$url = $_POST["url"];
		MediaManager\GetImages::create()->saveImages($_POST["productId"], trim($_POST["url"]));
	}

	public function getGImagesProgress()
	{
		$count = MediaManager\GetImages::create()->getProgress();
		echo json_encode(array("count" => $count));
	}

	private function deleteOldImageVariant($productId, $images)
	{
		foreach ($images as $k => $image ) {
			if (!preg_match("/additionalImages/i", $k)) {
				$id = end(explode("image", $k));
				$res = $this->db->order_by("id", "asc")->where("product_id", $productId)->get("shop_product_variants")->result_array();
				$this->unlinkImage($res[$id]["mainImage"]);
			}
		}
	}

	private function deleteOldImageVariantInternet($productId, $position)
	{
		$res = $this->db->order_by("id", "asc")->where("product_id", $productId)->get("shop_product_variants")->result_array();
		$this->unlinkImage($res[$position]["mainImage"]);
	}

	private function unlinkImage($name)
	{
		unlink("./uploads/shop/products/origin/" . $name);
		unlink("./uploads/shop/products/additional/" . $name);
		unlink("./uploads/shop/products/large/" . $name);
		unlink("./uploads/shop/products/main/" . $name);
		unlink("./uploads/shop/products/medium/" . $name);
		unlink("./uploads/shop/products/small/" . $name);
	}

	public function edit($productId, $locale = NULL)
	{
		$locale = ($locale == NULL ? MY_Controller::getCurrentLocale() : $locale);
		$model = SProductsQuery::create()->useProductVariantQuery()->orderByPosition()->endUse()->leftJoinWith("ProductVariant")->findPk((int) $productId);

		if ($model === NULL) {
			$this->error404(lang("Product not found", "admin"));
		}

		CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id(), "url" => $model->getUrl()), "ShopAdminProducts:preEdit");
		CMSFactory\Events::runFactory();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());
			$validation = $this->form_validation->set_rules("Created", lang("Date Created", "admin"), "required|valid_date");
			$validation = $model->validateCustomData($validation);

			if ($validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$categ_id = $model->getCategoryId();
				$prod_variants = $model->getProductVariants();
				$images = $this->upload_all();
				$datas = $this->input->post();
				$data = array("product_name" => $datas["Name"], "active" => $datas["Active"], "variant_name" => $datas["variants"]["Name"][0], "price_in_main" => $datas["variants"]["PriceInMain"][0], "currency" => $datas["variants"]["currency"][0], "number" => $datas["variants"]["Number"][0], "stock" => $datas["variants"]["Stock"][0], "brand_id" => $datas["BrandId"], "category_id" => $datas["CategoryId"], "additional_categories_ids" => $datas["Categories"], "short_description" => $datas["ShortDescription"], "full_description" => $datas["FullDescription"], "old_price" => $datas["OldPrice"], "tpl" => $datas["tpl"], "url" => $datas["Url"], "meta_title" => $datas["MetaTitle"], "meta_keywords" => $datas["MetaKeywords"], "meta_description" => $datas["MetaDescription"], "enable_comments" => $datas["EnableComments"], "related_products" => $datas["RelatedProducts"], "created" => strtotime($_POST["Created"]), "updated" => time());
				$this->deleteOldImageVariant($productId, $images);

				if ($datas["changeImage"][0]) {
					$data["mainImage"] = ($images["image0"] ? $images["image0"] : "");
				}
				else if ($datas["variants"]["inetImage"][0]) {
					$this->deleteOldImageVariantInternet($productId, 0);
					$p_images = MediaManager\GetImages::create()->saveImage($datas["variants"]["inetImage"][0]);
					$images["image0"] = $p_images;
					$data["mainImage"] = $p_images;
				}

				if ($datas["variants"]["MainImageForDel"][0]) {
					MediaManager\Image::create()->deleteAllProductImages($datas["variants"]["mainImageName"][0]);
					$data["mainImage"] = "";
				}

				$model = Products\ProductApi::getInstance()->updateProduct((int) $productId, $data, $locale, $datas["variants"]["CurrentId"][0]);

				if (Products\ProductApi::getInstance()->getError()) {
					showMessage(Products\ProductApi::getInstance()->getError(), "", "r");
					exit();
				}

				if (1 < count($datas["variants"]["PriceInMain"])) {
					$i = 1;

					while ($i < count($datas["variants"]["PriceInMain"])) {
						$p_price = array("number" => $datas["variants"]["Number"][$i], "stock" => $datas["variants"]["Stock"][$i], "currency" => $datas["variants"]["currency"][$i], "price_in_main" => $datas["variants"]["PriceInMain"][$i], "position" => $i, "variant_name" => $datas["variants"]["Name"][$i]);

						if ($datas["changeImage"][$i]) {
							$p_price["mainImage"] = ($images["image" . $i] ? $images["image" . $i] : "");
						}
						else if ($datas["variants"]["inetImage"][$i]) {
							$this->deleteOldImageVariantInternet($productId, $i);
							$p_images = MediaManager\GetImages::create()->saveImage($datas["variants"]["inetImage"][$i]);
							$images["image" . $i] = $p_images;
							$p_price["mainImage"] = $p_images;
						}

						if ($datas["variants"]["MainImageForDel"][$i]) {
							MediaManager\Image::create()->deleteAllProductImages($datas["variants"]["mainImageName"][$i]);
							$p_price["mainImage"] = "";
						}

						if ($datas["variants"]["CurrentId"][$i]) {
							$curr_prod_variant[] = $datas["variants"]["CurrentId"][$i];
							$query_prod_variant = Products\ProductApi::getInstance()->updateVariant($productId, $p_price, $locale, $datas["variants"]["CurrentId"][$i]);
						}
						else {
							$query_prod_variant = Products\ProductApi::getInstance()->addVariant($productId, $p_price, $locale);
						}

						++$i;

					}
				}

				$prod_array = array();
				$curr_prod_variant[] = $datas["variants"]["CurrentId"][0];

				foreach ($prod_variants as $variant ) {
					if (!in_array($variant->getId(), $curr_prod_variant)) {
						$prod_array[] = $variant->getId();
					}
				}

				if (0 < count($prod_array)) {
					foreach ($prod_array as $key => $value ) {
						$res = $this->db->where("id", $value)->get("shop_product_variants")->row_array();
						$this->unlinkImage($res["mainImage"]);
					}

					SProductVariantsQuery::create()->filterById($prod_array)->delete();
				}

				if (0 < sizeof($_POST["productProperties"])) {
					foreach ($_POST["productProperties"] as $property_id => $prod_property ) {
						if (!empty($prod_property)) {
							Products\ProductApi::getInstance()->setProductPropertyValue($productId, $property_id, $prod_property, $locale);
						}
						else {
							Products\ProductApi::getInstance()->deleteProductPropertyValue($productId, $property_id);
						}
					}
				}

				if ((int) $data["category_id"] != $categ_id) {
					$this->deleteProductsPropertiesData($productId, $categ_id);
				}

				MediaManager\Image::create()->checkOriginFolder();
				MediaManager\Image::create()->checkImagesFolders();
				MediaManager\Image::create()->checkWatermarks();
				MediaManager\Image::create()->resizeByName($images);
				$additional = $this->upload_all_additionalImages();
				$j = 0;
				$params = array("upload_dir" => "./uploads/shop/products/origin/additional/");
				MediaManager\GetImages::create($params);

				while (key_exists("add_img_urls_" . $j, $datas)) {
					if (!empty($datas["add_img_urls_" . $j]) & !key_exists($j, $additional)) {
						if (false !== $image = MediaManager\GetImages::create($params)->saveImage($datas["add_img_urls_" . $j])) {
							$additional[$j] = $image;
						}
					}

					++$j;
				}

				$results = array();

				foreach ($additional as $position => $image ) {
					MediaManager\Image::create()->makeResizeAndWatermarkAdditional($image);
					$results[] = Products\ProductApi::getInstance()->saveProductAdditionalImage($productId, $image, $position);
				}

				CMSFactory\Events::create()->registerEvent(array("productId" => $model->getId(), "url" => $model->getUrl(), "userId" => $this->dx_auth->get_user_id()));
				CMSFactory\Events::runFactory();
				Notificator::run($model->getId());
				$this->lib_admin->log(lang("The product was edited", "admin") . ". Id: " . $productId);
				showMessage(lang("The product was successfully edited", "admin"));
				$action = $_POST["action"];

				if ($action == "close") {
					pjax("/admin/components/run/shop/search/index" . $_SESSION["ref_url"]);
				}
				else {
					pjax("/admin/components/run/shop/products/edit/" . $model->getId() . "/" . $locale . $_SESSION["ref_url"]);
				}
			}
		}
		else {
			$productCategories = array();

			foreach ($model->getCategories() as $category_item ) {
				array_push($productCategories, $category_item->getId());
			}

			$additionalImagePositions = array();

			foreach ($model->getSProductImagess() as $addImage ) {
				$additionalImagePositions[$addImage->getPosition()] = $addImage;
			}

			$model->setLocale($locale);

			foreach ($model->getProductVariants() as $variant ) {
				$variant->setLocale($locale);
			}

			$currencies = SCurrenciesQuery::create()->find();
			$links = $this->prev_next($model->getId(), $this->get_ids($_GET));
			$brands = SBrandsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderById()->find();
			$this->render("edit", array("brands" => $brands, "model" => $model, "languages" => ShopCore::$ci->cms_admin->get_langs(true), "categories" => ShopCore::app()->SCategoryTree->getTree_(), "productCategories" => $productCategories, "additionalImagePositions" => $additionalImagePositions, "warehouses" => SWarehousesQuery::create()->orderByName()->find(), "defaultLocale" => MY_Controller::defaultLocale(), "locale" => $locale, "currencies" => $currencies, "prev_id" => $links["prev"], "next_id" => $links["next"], "imagesPopup" => $this->render("images", array(), true)));
		}
	}

	private function deleteProductsPropertiesData($productId, $category_ids)
	{
		if (!is_array($category_ids)) {
			$category_ids = array($category_ids);
		}

		if (!is_array($productId)) {
			$productId = array($productId);
		}

		$product_property = $this->db->select("property_id")->where_in("category_id", $category_ids)->get("shop_product_properties_categories");

		if ($product_property) {
			$product_property = $product_property->result_array();
			$product_property_id = array();

			foreach ($product_property as $property ) {
				$product_property_id[] = (int) $property["property_id"];
			}

			SProductPropertiesDataQuery::create()->filterByProductId($productId)->filterByPropertyId($product_property_id)->delete();
		}
	}

	public function delete()
	{
		$model = SProductsQuery::create()->findPk((int) $_POST["productId"]);

		if ($model !== NULL) {
			$model->delete();
		}

		CMSFactory\Events::create()->registerEvent(array("productId" => $this->input->post("productId"), "userId" => $this->dx_auth->get_user_id()));
		CMSFactory\Events::runFactory();
	}

	public function ajaxChangeActive($productId = NULL)
	{
		if (0 < count($_POST["ids"])) {
			$model = SProductsQuery::create()->findPks($_POST["ids"]);

			foreach ($model as $product ) {
				$product->setActive(!$product->getActive());
				$product->save();
			}

			pjax($url);
		}
		else {
			$model = SProductsQuery::create()->findPk($productId);

			if ($model !== NULL) {
				$model->setActive(!$model->getActive());
				$model->save();
			}
		}

		CMSFactory\Events::create()->registerEvent(array("model" => $model, "userId" => $this->dx_auth->get_user_id()), "ShopAdminProducts:ajaxChangeActive");
		CMSFactory\Events::runFactory();
	}

	public function ajaxChangeHit($productId = NULL)
	{
		$model = SProductsQuery::create()->findPk($productId);

		if ($model !== NULL) {
			$model->setHit(!$model->getHit());
			$model->save();
			$this->cache->delete_all();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SProductsQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $product ) {
					$product->setHit(!$product->getHit());
					$product->save();
				}
			}

			$url = $_SERVER["HTTP_REFERER"];
			$this->cache->delete_all();
			pjax($url);
		}
	}

	public function ajaxChangeHot($productId = NULL)
	{
		$model = SProductsQuery::create()->findPk($productId);

		if ($model !== NULL) {
			$model->setHot(!$model->getHot());
			$model->save();
			$this->cache->delete_all();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SProductsQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $product ) {
					$product->setHot(!$product->getHot());
					$product->save();
				}
			}

			$url = $_SERVER["HTTP_REFERER"];
			$this->cache->delete_all();
			pjax($url);
		}
	}

	public function ajaxChangeAction($productId = NULL)
	{
		$model = SProductsQuery::create()->findPk($productId);

		if ($model !== NULL) {
			$model->setAction(!$model->getAction());
			$model->save();
			$this->cache->delete_all();
		}

		if (sizeof(0 < $_POST["ids"])) {
			$model = SProductsQuery::create()->findPks($_POST["ids"]);

			if (!empty($model)) {
				foreach ($model as $product ) {
					$product->setAction(!$product->getAction());
					$product->save();
				}
			}

			$url = $_SERVER["HTTP_REFERER"];
			$this->cache->delete_all();
			pjax($url);
		}
	}

	public function ajaxUpdatePrice($productId = NULL)
	{
		if ($productId !== NULL) {
			$productVariant = SProductVariantsQuery::create()->filterByProductId($productId);

			if (isset($_POST["variant"])) {
				$productVariant = $productVariant->filterById($_POST["variant"]);
			}

			$productVariant = $productVariant->findOne();
			$productVariant->setPriceInMain($_POST["price"]);
			$productVariant->setPrice($_POST["price"], $productVariant->getCurrency());
			$productVariant->save();
			CMSFactory\Events::create()->registerEvent(array("productId" => $productId, "userId" => $this->dx_auth->get_user_id()), "ShopAdminProducts:edit");
			CMSFactory\Events::runFactory();
			showMessage(lang("Price updated", "admin"));
		}
	}

	public function ajaxCloneProducts()
	{
		if (sizeof($_POST["ids"])) {
			$products = SProductsQuery::create()->findPks($_POST["ids"]);

			foreach ($products as $p ) {
				$cloned = $p->copy();
				$cloned->setName($p->getName() . lang("(copy)", "admin"));
				$cloned->setUpdated(time());
				$cloned->setMetaTitle($p->getMetaTitle());
				$cloned->setMetaDescription($p->getMetaDescription());
				$cloned->setMetaKeywords($p->getMetaKeywords());
				$cloned->setFullDescription($p->getFullDescription());
				$cloned->setShortDescription($p->getShortDescription());
				$cloned->save();
				$cloned->setUrl($cloned->getId());
				$cloned->save();
				$variants = SProductVariantsQuery::create()->joinWithI18n(MY_Controller::defaultLocale())->filterByProductId($p->getId())->find();

				foreach ($variants as $v ) {
					if ($v->getMainImage()) {
						$NewImageName = "c_" . $v->getMainImage();
					}
					else {
						$NewImageName = "";
					}

					$variantClone = $v->copy(true);
					$variantClone->clearShopKitProducts();
					$variantClone->setProductId($cloned->getId())->setMainimage($NewImageName)->save();

					if ($NewImageName) {
						copy(PUBPATH . "uploads/shop/products/origin/" . $v->getMainImage(), PUBPATH . "uploads/shop/products/origin/" . $NewImageName);
						MediaManager\Image::create()->resizeByName($NewImageName);
					}
				}

				$langs = $this->db->get("languages")->result_array();

				foreach ($langs as $lan ) {
					$productI18nOrigin = SProductsI18nQuery::create()->filterById($p->getId())->FilterByLocale($lan["identif"])->findOne();

					if ($productI18nOrigin) {
						unset($productI18n);
						$productI18n = SProductsI18nQuery::create()->filterById($cloned->getId())->FilterByLocale($lan["identif"])->findOne();

						if (!$productI18n) {
							$productI18n = new SProductsI18n();
							$productI18n->setId($cloned->getId());
							$productI18n->setLocale($lan["identif"]);
						}

						$productI18n->setName($productI18nOrigin->getName() . lang("(copy)", "admin"));
						$productI18n->setMetaTitle($productI18nOrigin->getMetaTitle());
						$productI18n->setMetaDescription($productI18nOrigin->getMetaDescription());
						$productI18n->setMetaKeywords($productI18nOrigin->getMetaKeywords());
						$productI18n->setFullDescription($productI18nOrigin->getFullDescription());
						$productI18n->setShortDescription($productI18nOrigin->getShortDescription());
						$productI18n->save();
					}

					$name = array();
					$ProductVarOrigin = SProductVariantsQuery::create()->filterByProductId($p->getId())->find();

					if (count($ProductVarOrigin)) {
						foreach ($ProductVarOrigin as $prodVarOrigin ) {
							$productvarI18nOrigin = SProductVariantsI18nQuery::create()->filterById($prodVarOrigin->getId())->filterByLocale($lan["identif"])->findOne();

							if ($productvarI18nOrigin) {
								$name[] = $productvarI18nOrigin->getName();
							}
						}
					}
								
					$prodId = (int) $cloned->getId();
					$productVarIds = SProductVariantsQuery::create()->filterByProductId($prodId)->find();

					if (count($productVarIds)) {
						$cnt = 0;

						foreach ($productVarIds as $prodVar ) {
							unset($productvarI18n);
							$productvarI18n = SProductVariantsI18nQuery::create()->filterById($prodVar->getId())->filterByLocale($lan["identif"])->findOne();

							if ($name[$cnt]) {
								if (!$productvarI18n) {
									$productvarI18n = new SProductVariantsI18n();
									$productvarI18n->setLocale($lan["identif"]);
									$productvarI18n->setId($prodVar->getId());
								}

								$productvarI18n->setName($name[$cnt] . lang("(copy)", "admin"));
								$productvarI18n->save();
							}

							++$cnt;
						}
					}
				}

				$cats = ShopProductCategoriesQuery::create()->filterByProductId($p->getId())->find();

				if (0 < count($cats)) {
					foreach ($cats as $CatClone ) {
						$CC = new ShopProductCategories();
						$CC->setProductId($cloned->getId());
						$CC->setCategoryId($CatClone->getCategoryId());
						$CC->save();
					}
				}

				$props = SProductPropertiesDataQuery::create()->filterByProductId($p->getId())->find();

				if (0 < $props->count()) {
					foreach ($props as $prop ) {
						$propClone = new SProductPropertiesData();
						$propClone->setProductId($cloned->getId());
						$propClone->setPropertyId($prop->getPropertyId());
						$propClone->setLocale($prop->getLocale());
						$propClone->setValue($prop->getValue());
						$propClone->save();
					}
				}

				$cloned->save();
				ShopCore::app()->CustomFieldsHelper->copyProductCustomFieldsData($p->getId(), $cloned->getId());

				try {
					MediaManager\Image::create()->checkOriginFolder();
					$additionalImages = SProductImagesQuery::create()->filterByProductId($p->getId())->find();

					if (count($additionalImages)) {
						foreach ($additionalImages as $img ) {
							$additionalImages = ShopCore::$imagesUploadPath . "products/origin/additional/" . $img->getImageName();

							if (file_exists($additionalImages)) {
								$ext = pathinfo($additionalImages, PATHINFO_EXTENSION);
								$additionalImagesCloned = $cloned->getId() . "_" . $img->getPosition() . "." . $ext;
								$ClonedImgOrig = ShopCore::$imagesUploadPath . "products/origin/additional/" . $additionalImagesCloned;
								$ClonedImg = new SProductImages();
								$ClonedImg->setImageName($additionalImagesCloned);
								$ClonedImg->setProductId($cloned->getId());
								$ClonedImg->setPosition($img->getPosition());
								$ClonedImg->save();
								copy($additionalImages, $ClonedImgOrig);
							}
						}

						MediaManager\Image::create()->resizeByIdAdditional($cloned->getId());
						
						showMessage($e->getMessage(), "", "r");
					}
				}
				catch (PropelException $e) {
					showMessage($e->getMessage(), "", "r");
				}

				$status = $cloned->save();
				$message = lang("Created product clone. Id:", "admin") . " " . $p->getId() . ". " . lang("Copy product ID:", "admin") . " " . $cloned->getId();
				$this->lib_admin->log($message);
			}

			Currency\Currency::create()->checkPrices();
			showMessage(lang("A copy was successfully created", "admin"));
			pjax($_SERVER["HTTP_REFERER"]);
		}
	}

	public function ajaxDeleteProducts()
	{
		$prod_ids = SProductsQuery::create()->findPks($_POST["ids"]);

		foreach ($_POST["ids"] as $id ) {
			Products\ProductApi::getInstance()->deleteProduct($id);
		}

		$this->lib_admin->log(lang("The product was removed", "admin") . ". IdS: " . implode(", ", $_POST["ids"]));
		showMessage(lang("Deleted complete", "admin"));
		CMSFactory\Events::create()->registerEvent(array("model" => $prod_ids, "userId" => $this->dx_auth->get_user_id()), "ShopAdminProducts:delete");
		CMSFactory\Events::runFactory();
	}

	public function ajaxMoveProducts()
	{
		$category_id = $this->input->post("categoryId");
		$newCategoryModel = SCategoryQuery::create()->findPk($category_id);
		$products = SProductsQuery::create()->findPks($_POST["ids"]);
		$category_ids = array();

		foreach ($products as $product ) {
			$category_ids[] = $product->getCategoryId();
		}

		$product_property = $this->db->select("property_id,category_id")->where_in("category_id", $category_ids)->get("shop_product_properties_categories");

		if ($product_property) {
			$product_property = $product_property->result_array();
			$product_property_id_list = $this->db->select("property_id")->where("category_id", $category_id)->get("shop_product_properties_categories");

			if ($product_property_id_list) {
				$product_property_id_list = $product_property_id_list->result_array();
				$product_property_ids = array();

				foreach ($product_property_id_list as $product_property_item ) {
					$product_property_ids[] = $product_property_item["property_id"];
				}

				$product_property_id = array();

				foreach ($product_property as $property ) {
					if (!in_array($property["property_id"], $product_property_ids)) {
						$product_property_id[] = $property["property_id"];
					}
				}

				SProductPropertiesDataQuery::create()->filterByProductId($_POST["ids"])->filterByPropertyId($product_property_id)->delete();
			}
		}

		if (($newCategoryModel !== NULL) && !empty($products)) {
			foreach ($products as $product ) {
				$product->setCategoryId($newCategoryModel->getId());
				$product->addCategory($newCategoryModel);
				$product->save();
				$message = lang("Product Id:", "admin") . $product->getId() . " " . lang("moved in category. Category Id:", "admin") . $newCategoryModel->getId();
				$this->lib_admin->log($message);
			}

			pjax("/admin/components/run/shop/search/index/?CategoryId=" . $category_id);
		}
	}

	public function get_ids($param)
	{
		$model = SProductsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->leftJoinProductVariant();

		if (isset($param["CategoryId"]) && (0 < $param["CategoryId"])) {
			$model = $model->filterByCategoryId((int) $param["CategoryId"]);
		}

		if (isset($param["filterID"]) && (0 < $param["filterID"])) {
			$model = $model->filterById((int) $param["filterID"]);
		}

		if (isset($param["number"]) && ($param["number"] != "")) {
			$model = $model->where("ProductVariant.Number = ?", $param["number"]);
		}

		if (!empty($param["text"])) {
			$text = $param["text"];

			if (!strpos($text, "%")) {
				$text = "%" . $text . "%";
			}

			$model = $model->useI18nQuery($this->defaultLanguage["identif"])->where("SProductsI18n.Name LIKE ?", $text)->endUse()->_or()->where("ProductVariant.Number = ?", $text);
		}

		if (isset($param["min_price"]) && (0 < $param["min_price"])) {
			$model = $model->where("ProductVariant.Price >= ?", $param["min_price"]);
		}

		if (isset($param["max_price"]) && (0 < $param["max_price"])) {
			$model = $model->where("ProductVariant.Price <= ?", $param["max_price"]);
		}

		if ($param["Active"] == "true") {
			$model = $model->filterByActive(true);
		}
		else if ($this->input->get("Active") == "false") {
			$model = $model->filterByActive(false);
		}

		if (isset($param["s"])) {
			if ($param["s"] == "Hit") {
				$model = $model->filterByHit(true);
			}

			if ($param["s"] == "Hot") {
				$model = $model->filterByHot(true);
			}

			if ($param["s"] == "Action") {
				$model = $model->filterByAction(true);
			}
		}

		$model = $model->offset((int) ShopCore::$_GET["per_page"])->distinct()->find();
		$res = NULL;

		foreach ($model as $p ) {
			$res[] .= $p->getId();
		}

		return $res;
	}

	public function prev_next($cur, $arr = NULL)
	{
		$res = NULL;

		if (in_array($cur, $arr)) {
			$index_cur = array_search($cur, $arr);
			$res["prev"] = $arr[$index_cur - 1];
			$res["next"] = $arr[$index_cur + 1];
		}
		else {
			$res = NULL;
		}

		return $res;
	}


	public function deleteAddImage($id, $pos)
	{
		$image = $this->db->where("product_id", $id)->where("position", $pos)->get("shop_product_images")->row_array();
		$imageForDelete = $image["image_name"];
		MediaManager\Image::create()->deleteAllProductAdditionalImages($imageForDelete);
		$this->db->where("product_id", $id)->where("position", $pos)->delete("shop_product_images");
	}


	public function upload_all()
	{
		$files = array();
		$config = array();
		$config["upload_path"] = "./uploads/shop/products/origin";
		$config["allowed_types"] = "gif|jpg|jpeg|png";
		$config["encrypt_name"] = true;
		$this->upload->initialize($config);

		foreach ($_FILES as $key => $value ) {
			if (!$this->upload->do_upload($key)) {
				showMessage($this->upload->display_errors(), "", "r");
				exit();
			}
			else {
				$result = array("upload_data" => $this->upload->data());
				$files[$key] .= $result["upload_data"]["file_name"];
			}
		}

		foreach ($files as $k => $value ) {
			if (preg_match("/additionalImages/i", $k)) {
				unlink("./uploads/shop/products/origin/" . $value);
			}
		}

		return $files;
	}

	public function upload_all_additionalImages()
	{
		$files = array();
		$this->upload->initialize(array("upload_path" => "./uploads/shop/products/origin/additional", "allowed_types" => "gif|jpg|jpeg|png", "encrypt_name" => true));

		foreach ($_FILES as $key => $value ) {
			if (!$this->upload->do_upload($key)) {
				showMessage($this->upload->display_errors(), "", "r");
				exit();
			}
			else {
				$result = array("upload_data" => $this->upload->data());
				$matches = array();
				preg_match("/[\d]+/", $key, $matches);

				if (strstr($key, "additionalImages")) {
					$files[$matches[0]] .= $result["upload_data"]["file_name"];
				}
				else {
					unlink("./uploads/shop/products/origin/additional/" . $result["upload_data"]["file_name"]);
				}
			}
		}

		return $files;
	}

	public function fastCategoryCreate()
	{
		$post = $this->input->post();

		if ($post["name"]) {
			$locale = MY_Controller::defaultLocale();
			$data = array("name" => $post["name"], "parent_id" => (int) $post["parent_id"], "active" => 1);

			if ($model = Category\CategoryApi::getInstance()->addCategory($data, $locale)) {
				$message = lang("Category created", "admin");
				$categories = ShopCore::app()->SCategoryTree->getTree_();
				$categories = $this->render("categories_selector", array("categories" => $categories, "selected_id" => $model->getId()), true);
				echo json_encode(array("success" => true, "message" => $message, "categories" => $categories));
			}
			else {
				$message = Category\CategoryApi::getInstance()->getError();
				echo json_encode(array("success" => false, "message" => $message));
			}
		}
		else {
			$message = lang("Can not create categoty without name.", "admin");
			echo json_encode(array("success" => false, "message" => $message));
		}
	}

	public function fastBrandCreate()
	{
		$post = $this->input->post();

		if ($post["name"]) {
			$this->load->helper("translit");
			$data = array("url" => translit_url($post["name"]), "image" => "", "position" => 0, "created" => time(), "updated" => time());
			$find_url = SBrandsQuery::create()->where("SBrands.Url = ?", $data["url"])->findOne();

			if ($find_url !== NULL) {
				echo json_encode(array("success" => false, "message" => lang("This URL is already in use", "admin")));
				return;
			}

			$this->db->insert("shop_brands", $data);
			$brand_id = $this->db->insert_id();
			$shop_brands_i18n = array("id" => $brand_id, "name" => $post["name"], "locale" => MY_Controller::defaultLocale());

			if ($this->db->insert("shop_brands_i18n", $shop_brands_i18n)) {
				$message = lang("Brand created", "admin");
				$brands = SBrandsQuery::create()->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->orderByPosition();
				$offset = 0;
				$per_page = 10000;
				$brands = $brands->distinct()->limit($per_page)->offset((int) $offset)->find();
				$brands = $this->render("brands_selector", array("brands" => $brands, "selected_id" => $brand_id), true);
				echo json_encode(array("success" => true, "message" => $message, "brands" => $brands));
			}
			else {
				$message = lang("Can not create brand without name.", "admin");
				echo json_encode(array("success" => false, "message" => $message));
			}
		}
		else {
			$message = lang("Can not create brand without name.", "admin");
			echo json_encode(array("success" => false, "message" => $message));
		}
	}
}



?>
