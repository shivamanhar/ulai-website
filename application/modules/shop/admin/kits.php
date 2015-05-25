<?php


class ShopAdminKits extends ShopAdminController
{
	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
	}

	public function index()
	{
		$model = ShopKitQuery::create()->joinWith("SProducts")->useQuery("SProducts")->joinWithI18n(MY_Controller::defaultLocale(), Propel\Runtime\ActiveQuery\Criteria::JOIN)->endUse()->orderById(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();
		$this->render("index", array("model" => $model));
	}

	public function kit_create($mainProductId = NULL)
	{
		$model = new ShopKit();

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$mainProductId = $this->input->post("MainProductId");
				$attachedProductsIds = $_POST["AttachedProductsIds"];

				foreach ($_POST["AttachedProductsIds"] as $key => $value ) {
					$attachedProductsDiscounts[$value] = $_POST["Discounts"][$key];
				}

				$FindPKProductId = SProductsQuery::create()->findPk($mainProductId);

				if ($FindPKProductId === NULL) {
					exit(showMessage(ShopCore::t(lang("You did not ask for a set of main commodity", "admin")), "", "r"));
				}

				$attachedProducts = SProductsQuery::create()->findPks($attachedProductsIds);

				if ($attachedProducts->count() === 0) {
					exit(showMessage(ShopCore::t(lang("You must attach the goods to create a set", "admin")), "", "r"));
				}

				$kitCheck = $this->_kitCheck($mainProductId, $attachedProductsIds);

				if ($kitCheck === false) {
					exit(showMessage(ShopCore::t(lang("Kit with such goods already exists", "admin")), "", "r"));
				}

				$model->fromArray($_POST);
				$calcNewKitPosition = $this->_calcNewKitPosition($mainProductId);
				$model->setPosition($calcNewKitPosition);
				$model->setProductId($mainProductId);

				foreach ($attachedProducts as $attachedProduct ) {
					$shopKitProduct = new ShopKitProduct();
					$shopKitProduct->setProductId($attachedProduct->getId());
					$shopKitProduct->setDiscount($attachedProductsDiscounts[$attachedProduct->getId()]);
					$model->addShopKitProduct($shopKitProduct);
				}

				$model->save();
				$shop_kit = $this->db->order_by("id", "desc")->get("shop_kit")->row()->id;
				$this->lib_admin->log(lang("Kit created", "admin") . ". Id: " . $shop_kit);
				showMessage(ShopCore::t(lang("Kit created", "admin")));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/kits/index");
				}

				if ($_POST["action"] == "save") {
					pjax("/admin/components/run/shop/kits/kit_edit/" . $model->getId());
				}
			}
		}
		else if ($mainProductId) {
			$model->setProductId($mainProductId);
		}
		else {

			$this->render("kit_create", array("model" => $model));
		}
	}

	public function kit_edit($kitId, $canChangeMainProduct = true)
	{
		$model = ShopKitQuery::create()->findPk($kitId);

		if ($model === NULL) {
			$this->error404(ShopCore::t(lang("The kit was not found", "admin")));
		}

		if (!empty($_POST)) {
			$this->form_validation->set_rules($model->rules());

			if ($this->form_validation->run($this) == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$_POST["Active"] = (int) $_POST["Active"];
				$_POST["OnlyForLogged"] = (int) $_POST["OnlyForLogged"];
				$mainProductId = $this->input->post("MainProductId");
				$attachedProductsIds = $_POST["AttachedProductsIds"];

				foreach ($_POST["AttachedProductsIds"] as $key => $value ) {
					$attachedProductsDiscounts[$value] = $_POST["Discounts"][$key];
				}

				$FindPKProductId = SProductsQuery::create()->findPk($mainProductId);

				if ($FindPKProductId === NULL) {
					exit(showMessage(ShopCore::t(lang("You did not ask for a set of main commodity ", "admin"))));
				}

				$attachedProducts = SProductsQuery::create()->findPks($attachedProductsIds);

				if ($attachedProducts->count() === 0) {
					exit(showMessage(ShopCore::t(lang("You must attach the goods to create a set", "admin"))));
				}

				$kitCheck = $this->_kitCheck($mainProductId, $attachedProductsIds, $model->getId());

				if ($kitCheck === false) {
					exit(showMessage(ShopCore::t(lang("Kit with such goods already exists", "admin"))));
				}

				$model->fromArray($_POST);
				$model->setProductId($mainProductId);
				ShopKitProductQuery::create()->filterByShopKit($model)->delete();

				foreach ($attachedProducts as $attachedProduct ) {
					$shopKitProduct = new ShopKitProduct();
					$shopKitProduct->setProductId($attachedProduct->getId());
					$shopKitProduct->setDiscount($attachedProductsDiscounts[$attachedProduct->getId()]);
					$model->addShopKitProduct($shopKitProduct);
				}

				$model->save();
				$this->lib_admin->log(lang("Kit edited", "admin") . ". Id: " . $kitId);
				showMessage(ShopCore::t(lang("Changes have been saved", "admin")));

				if ($_POST["action"] == "tomain") {
					pjax("/admin/components/run/shop/kits/index");
				}
			}
		}
		else {
			$this->render("kit_edit", array("model" => $model, "canChangeMainProduct" => $canChangeMainProduct));
		}
	}

	public function kit_save_positions()
	{
		if (0 < sizeof($_POST["Position"])) {
			foreach ($_POST["Position"] as $id => $pos ) {
				ShopKitQuery::create()->filterById($id)->update(array("Position" => (int) $pos));
			}
		}
	}

	public function kit_change_active($kitId)
	{
		$model = ShopKitQuery::create()->findPk($kitId);

		if ($model !== NULL) {
			$model->setActive(!$model->getActive());

			if ($model->save()) {
				showMessage(lang("Changes have been saved", "admin"));
			}
		}
	}

	public function kit_delete()
	{
		$kitId = $this->input->post("ids");
		$model = ShopKitQuery::create()->findPks($kitId);

		if ($model != NULL) {
			$model->delete();
		}

		if (1 < count($kitId)) {
			$message = lang("Kits has been removed", "admin");
		}
		else {
			$message = lang("Kit has been removed", "admin");
		}

		$this->lib_admin->log($message . ". Ids: " . implode(", ", $kitId));
		showMessage($message);
	}

	protected function _kitCheck($mainProductId, $attachedPIds, $kit = NULL)
	{
		$kits = ShopKitQuery::create();

		if ($kit !== NULL) {
			$kits = $kits->filterById($kit, Propel\Runtime\ActiveQuery\Criteria::NOT_IN);
		}

		$kits = $kits->filterByProductId($mainProductId)->find();

				  //if there are exist some kit|kits with a same main product
        if ($kits->count() > 0) {
            //getting attached products ids array of these kits
            foreach ($kits as $kit) {
                $criteria = ShopKitProductQuery::create()
                        ->select(array('ProductId'));
                $pIds = $kit->getShopKitProducts($criteria)
                        ->toArray();

                //count the total atached products to a kit in db
                $attachedPIdsCount = count($attachedPIds);

                //if a kit from a db has the same products number
                if (count($pIds) == $attachedPIdsCount) {
                    //check if there are difference between those kits
                    $pIdsDiff = array_diff($pIds, $attachedPIds);

                    //return FALSE if the kits are the same
                    if (empty($pIdsDiff))
                        return FALSE;
                }
            }
        }

		return true;
	}

	protected function _calcNewKitPosition($mainProductId = NULL)
	{
		if ($mainProductId !== NULL) {
			$kit = ShopKitQuery::create()->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::DESC)->filterByProductId($mainProductId)->limit(1)->findOne();

			if ($kit !== NULL) {
				return $kit->getPosition() + 1;
			}
		}

		return 0;
	}

	public function get_products_list($type = NULL)
	{
		$products = SProductsQuery::create()->joinI18n(MY_Controller::getCurrentLocale(), NULL, Propel\Runtime\ActiveQuery\Criteria::JOIN);

		if (!empty($_POST["noids"])) {
			$noids = explode(",", $_POST["noids"]);
			$products->filterById($noids, Propel\Runtime\ActiveQuery\Criteria::NOT_IN);
		}
		else {
			$noids = array();
		}

		$searched = ($this->input->get("term") ? $this->input->get("term") : $this->input->post("q"));

		if ($searched) {
			if ($type != "number") {
				$products = $products->filterById($searched)->_or()->useI18nQuery(MY_Controller::getCurrentLocale())->filterByName("%" . $searched . "%")->endUse()->_or()->useProductVariantQuery()->filterByNumber("%" . $searched . "%")->endUse();
			}
			else {
				$products = $products->useProductVariantQuery()->filterByNumber("%" . $searched . "%")->endUse();
			}
		}

		$products = $products->_if(!empty($_POST["limit"]))->limit((int) $_POST["limit"])->_endif()->distinct()->find();
		$variants = SProductVariantsQuery::create()->joinI18n(MY_Controller::getCurrentLocale(), NULL, Propel\Runtime\ActiveQuery\Criteria::JOIN)->filterBySProducts($products)->orderById(Propel\Runtime\ActiveQuery\Criteria::DESC)->find();

				foreach ($variants as $variant ) {
			if (in_array($variant->getProductId(), $noids)) {
				continue;
			}

			$ProductVariantArray[$variant->getProductId()][$variant->getId()]["name"] = ShopCore::encode($variant->getName());
			$ProductVariantArray[$variant->getProductId()][$variant->getId()]["price"] = $variant->getPrice();
			$ProductVariantArray[$variant->getProductId()][$variant->getId()]["number"] = $variant->getNumber();
		}

		foreach ($products as $key => $product ) {
			if ($ProductVariantArray[$product->getId()]) {
				foreach ($ProductVariantArray[$product->getId()] as $key => $variant ) {
					$name = ($variant["name"] ? $variant["name"] : $product->getName());
					$ProductLabel = ShopCore::encode($product->getId() . " - " . $name . " (" . $variant["number"] . ")");

					if (($type != NULL) && (0 < count($product))) {
					}
					else {
					}

					$response[] = array(
						"number"     => " - ",
						"label"      => $ProductLabel,
						"name"       => ShopCore::encode($product->getName()),
						"id"         => $product->getId(),
						"photo"      => $product->firstVariant->getSmallPhoto(),
						"price"      => $product->firstVariant->getPrice(),
						"value"      => $product->getId(),
						"category"   => $product->getCategoryId(),
						"variants"   => $ProductVariantArray[$product->getId()],
						"cs"         => Currency\Currency::create()->getSymbol(),
						"identifier" => array("id" => $product->getId())
						);
				}
			}
		}

		echo json_encode($response);
	}

	protected function _redirect($model, $entityName)
	{
		$controllerName = str_replace("ShopAdmin", "", get_class());
		$controllerName = strtolower($controllerName);

		if ($_POST["_add"]) {
			$redirect_url = $controllerName . "/" . $entityName . "_list";
		}

		if ($_POST["_create"]) {
			$redirect_url = $controllerName . "/" . $entityName . "_create";
		}

		if ($_POST["_edit"]) {
			$redirect_url = $controllerName . "/" . $entityName . "_edit/" . $model->getId();
		}

		if ($redirect_url !== NULL) {
			$this->ajaxShopDiv($redirect_url);
		}
	}
}


?>
