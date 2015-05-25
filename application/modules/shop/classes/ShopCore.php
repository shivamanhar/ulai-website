<?php

defined("SHOP_DIR") || define("SHOP_DIR", getModulePath("shop"));
defined("DS") || define("DS", "/");

class ShopCore
{
	private static $_initialized;
	private static $_imports = array();
	private static $_includePaths = array();
	protected static $_componentsClass;
	public static $_GET = array();
	public static $template_path;
	public static $currentCategory;
	public static $ci;
	public static $SHOP_APPLY_DISCOUNTS = true;
	public static $imagesUploadPath;

	public static function init()
	{
		if (self::$_initialized === NULL) {
			self::$_initialized = true;
			self::$ci = &get_instance();
			class_exists("ShopComponents", true);
			self::$_componentsClass = new ShopComponents();
			require_once (SHOP_DIR . "helpers/shop_helper" . EXT);
			self::$imagesUploadPath = PUBPATH . "uploads/shop/";
			$orm = Propel\Runtime\Propel::getServiceContainer();
			$orm->setAdapterClass("Shop", "mysql");
			$manager = new Propel\Runtime\Connection\ConnectionManagerSingle();
			$manager->setConfiguration(array(
				"dsn"      => "mysql:host=" . self::$ci->db->hostname . ";dbname=" . self::$ci->db->database,
				"user"     => self::$ci->db->username,
				"password" => self::$ci->db->password,
				"settings" => array("charset" => "utf8")
				));
			$orm->setConnectionManager("Shop", $manager);
			$con = Propel\Runtime\Propel::getWriteConnection("Shop");

			if (ENVIRONMENT != "production") {
			}

			self::$_GET = self::$ci->input->get(NULL, true);
		}
	}

	public static function initEnviroment()
	{
		$ci = &get_instance();
		$path = ShopCore::app()->SSettings->systemTemplatePath;

		if (isset($_SESSION["freferer"])) {
			$facebook = $ci->db->where("name", "facebook_int")->get("shop_settings")->row();
			$facebook = unserialize($facebook->value);

			if ($facebook["use"] == 1) {
				$path = "./templates/" . $facebook["template"] . "/shop/default";
			}
		}

		if (isset($_SESSION["vreferer"])) {
			$vk = $ci->db->where("name", "vk_int")->get("shop_settings")->row();
			$vk = unserialize($vk->value);

			if ($vk["use"] == 1) {
				$path = "./templates/" . $vk["template"] . "/shop/default";
			}
		}

		$media_path = $path;
		self::$template_path = realpath($path) . "/";

		if ((1 < count(Currency\Currency::create()->getCurrencies())) && Currency\Currency::create()->default) {
			$currentCurrency = SCurrenciesQuery::create()->filterByIsDefault(1)->findOne();

			if (!$currentCurrency) {
				$currentCurrency = SCurrenciesQuery::create()->findOne();
			}

			$currentCurrency = $currentCurrency->getId();
		}

		Currency\Currency::create()->initCurrentCurrency(NULL);
		Currency\Currency::create()->initAdditionalCurrency($currentCurrency);

		if (substr($media_path, 0, 2) == "./") {
			$media_path = substr($media_path, 2);
		}

		$currency = SCurrenciesQuery::create()->filterById($currentCurrency, Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)->filterByShowonsite(1)->findOne();

		if ($currency) {
			$CurrencySymbol = ($currency->getShowOnSite() ? $currency->Symbol : "");
		}
		else {
			$CurrencySymbol = "";
		}

		$ci->template->add_array(array("SHOP_THEME" => media_url($media_path) . "/", "CS" => Currency\Currency::create()->getSymbol(), "NextCS" => $CurrencySymbol, "NextCSId" => $currency->Id));
	}

	public static function t($message, $category = "admin", $langfile = "main", array $params = array(), $language = NULL)
	{
		$langfile = $category . "_" . $langfile;

		if ($language === NULL) {
			$language = MY_Controller::getCurrentLocale();
		}

		switch ($category) {
		case "front":
			$filePath = self::$template_path;
		}

		if (!in_array($langfile . EXT, self::$ci->lang->is_loaded, true)) {
			ShopCore::$ci->lang->load($langfile, $language, false, NULL, true, $filePath);
		}

		$message = (lang($message) ? lang($message) : $message);

		if ($params === array()) {
			return $message;
		}

		if (!is_array($params)) {
			$params = array($params);
		}

		foreach ($params as $key => $value ) {
			$params["%$key%"] = $value;
			unset($array[$key]);
		}

		return strtr($message, $params);
	}

	public static function app()
	{
		return self::$_componentsClass;
	}

	public static function encode($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, "utf-8");
	}
}


?>
