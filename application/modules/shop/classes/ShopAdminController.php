<?php

class ShopAdminController extends MY_Controller
{
	public $baseAdminUrl = "/admin/components/run/shop/";
	public $shopThemeUrl;
	public $pjaxRequest = false;
	private static $cmsAdmin = true;

	public function __construct()
	{
		parent::__construct();
		$this->shopThemeUrl = getModulePath("shop") . "admin/templates/assets/";
		$lang = new MY_Lang();
		$lang->load("admin");

		if (isset($_SERVER["HTTP_X_PJAX"]) && ($_SERVER["HTTP_X_PJAX"] == true)) {
			$this->pjaxRequest = true;
			header("X-PJAX: true");
		}

		Permitions::checkPermitions();
		$this->autoloadModules();
		ShopCore::$SHOP_APPLY_DISCOUNTS = false;
		ShopCore::app()->SCurrencyHelper->initCurrentCurrency("main");
		$this->template->add_array(array("ADMIN_URL" => $this->baseAdminUrl, "SHOP_THEME" => $this->shopThemeUrl, "CS" => ShopCore::app()->SCurrencyHelper->getSymbol(), "Controller" => $this));
	}

	public function render($viewName, array $data = array(), $return = false)
	{
		if (!empty($data)) {
			$this->template->add_array($data);
		}

		if (1 < count(ShopCore::$ci->cms_admin->get_langs(true))) {
			$this->template->assign("translatable", "<i class=\"icon-flag\" data-title=\"" . lang("Translated field", "main") . "\"data-rel=\"tooltip\"></i>");
			$this->template->assign("translatable_w", "<i class=\"icon-flag\" data-title=\"" . lang("Translated field", "main") . "\"data-rel=\"tooltip\"></i>");
		}

		if ($this->pjaxRequest) {
			echo $this->template->fetch("file:" . $this->getViewFullPath($viewName));
		}
		else if ($return === false) {
			$this->template->show("file:" . $this->getViewFullPath($viewName));
		}
		else {
			return $this->template->fetch("file:" . $this->getViewFullPath($viewName));
		}
	}

	public function getViewFullPath($viewName)
	{
		$controllerName = str_replace("ShopAdmin", "", get_class($this));
		$controllerName[0] = strtolower($controllerName[0]);

		$ext = "";

		if (strpos($viewName, ".tpl")) {
			$ext = ".tpl";
		}

		return SHOP_DIR . "admin" . DS . "templates" . DS . $controllerName . DS . $viewName . $ext;
	}

	public function createUrl($url, array $args = array())
	{
		$url = $this->baseAdminUrl . $url;

		if (!empty($args)) {
			$url .= "/" . implode("/", $args);
		}

		return $url;
	}

	public function error404($message)
	{
		$this->template->assign("message", $message);
		$this->template->show("404");
		exit();
	}

	public function ajaxShopDiv($url, $div = false)
	{
		if (!$div) {
			echo "
		<script type=\"text/javascript\">
			ajaxShop(\"" . $url . "\");
		</script>
		";
		}
		else {
			echo "
		<script type=\"text/javascript\">
			ajaxShopDiv(\"" . $url . "\");
		</script>
		";
		}
	}

	private function autoloadModules()
	{
		$query = $this->db->select("name")->where("autoload", 1)->get("components");

		if ($query) {
			$moduleName = NULL;

			foreach ($query->result_array() as $module ) {
				$moduleName = $module["name"];
				Modules::load_file($moduleName, APPPATH . "modules" . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR);
				$moduleName = ucfirst($moduleName);

				if (class_exists($moduleName)) {
					if (method_exists($moduleName, "adminAutoload")) {
						$moduleName::adminAutoload();
					}
				}
			}
		}
	}

	public static function checkVarAdmin()
	{
		try {
			if (!isset(self::$cmsAdmin)) {
				////@@@ this check for import data corrupted				
				$msg = lang("Error checking permissions");
				$ci = &get_instance();
				$ci->template->assign("content", $msg);
				$msg = $ci->template->fetch("main");
				exit($msg);
			}
		}
		catch (Exception $exc) {
			$msg = lang("Error checking permissions");
			$ci = &get_instance();
			$ci->template->assign("content", $msg);
			$msg = $ci->template->fetch("main");
			exit($msg);
		}
	}
}


?>
