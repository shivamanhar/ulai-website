<?php

class ShopAdminDashboard extends ShopAdminController
{
	protected $perPage = 10;
	public $defaultLanguage;

	public function __construct()
	{
		parent::__construct();

		if (($this->dx_auth->is_admin() == true) && SHOP_INSTALLED) {
			pjax("/admin/components/run/shop/orders/index");
		}

		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->defaultLanguage = getDefaultLanguage();
	}

	public function index()
	{
		if (($this->dx_auth->is_admin() == true) && SHOP_INSTALLED) {
			redirect("/admin/components/run/shop/orders/index");
		}

		$model = SOrdersQuery::create()->filterByStatus(1)->orderByDateCreated(Propel\Runtime\ActiveQuery\Criteria::DESC);
		$model = $model->distinct()->limit($this->perPage)->find();
		$orderStatuses = SOrderStatusesQuery::create()->orderByPosition(Propel\Runtime\ActiveQuery\Criteria::ASC)->find();		
		$bestSellers =SProductsQuery::create()->orderByAddedToCartCount("desc")->filterBy("AddedToCartCount", 0, ">")->limit(10)->find();
		
		$newUsers = SUserProfileQuery::create()->orderByDateCreated("desc")->limit(10)->find();
		$amountPurchases = array();

		foreach ($newUsers as $user ) {
			$amountPurchases[$user->getId()] = 0;

			foreach (SOrdersQuery::create()->leftJoin("SOrderProducts")->distinct()->filterByUserId($user->getId())->find() as $order ) {
				if ($order->getPaid() == true) {
					foreach ($order->getSOrderProductss() as $p ) {
						$amountPurchases[$user->getId()] += $p->getQuantity() * $p->getPrice();
					}

					$amountPurchases[$user->getId()] += $order->getDeliveryPrice();
				}
			}
		}

		if ($this->db->get_where("components", array("name" => "comments"))->row()) {
			$sql = "SELECT * FROM `comments` ORDER BY `date` DESC LIMIT 10";
			$lastCommentsArray = $this->db->query($sql)->result_array();
		}

		

		CMSFactory\Events::create()->registerEvent("", "ShopDashboard:show");
		CMSFactory\Events::runFactory();
		$this->render("dashboard", array("model" => $model, "totalOrders" => $totalOrders, "deliveryMethods" => SDeliveryMethodsQuery::create()->useI18nQuery($this->defaultLanguage["identif"])->orderByName(Propel\Runtime\ActiveQuery\Criteria::ASC)->endUse()->find(), "paymentMethods" => SPaymentMethodsQuery::create()->useI18nQuery($this->defaultLanguage["identif"])->orderByName(Propel\Runtime\ActiveQuery\Criteria::ASC)->endUse()->find(), "orderStatuses" => $orderStatuses, "bestSellers" => $bestSellers, "newUsers" => $newUsers, "amountPurchases" => $amountPurchases, "lastCommentsArray" => $lastCommentsArray, "onLocal" => $onLocal));
	}
}


?>
