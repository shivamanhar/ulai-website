<?php

class ShopController extends MY_Controller
{
	protected $template_path;
	public static $currentLocale;
	public static $doShowUntranslated = false;
	public static $cmsVersion = "shop_premium";

	public function __construct()
	{
		parent::__construct();
		$this->template_path = ShopCore::$template_path;

		if (count($this->db->where("name", "mod_discount")->get("components")->result_array()) != 0) {
			$this->load->module("mod_discount")->register_script();
		}
	}

	public function render($name, $data = array(), $fetch = false)
	{
		$this->template->add_array($data);
		$content = $this->template->fetch("file:" . $this->template_path . $name . ".tpl");

		if ($fetch === false) {
			$this->template->assign("content", $content);
			$this->template->display("file:" . $this->template_path . "../main.tpl");
		}
		else {
			return $content;
		}
	}

	public function error404()
	{
		header("HTTP/1.0 404 Not Found");
		$this->render("error404", array("error" => ShopCore::t("Страница не найдена")));
		exit();
	}

	public static function getShowUntranslated()
	{
		return self::$doShowUntranslated;
	}

	public function render_min($name, $data = array(), $fetch = false)
	{
		$this->template->add_array($data);
		return $this->template->display("file:" . $this->template_path . $name . ".tpl");
	}

	public static function checkLicensePremium()
	{
		if (self::$cmsVersion !== "shop_premium") {
			$msg = lang("Error checking permissions");
			$ci = &get_instance();
			$ci->template->assign("content", $msg);
			$msg = $ci->template->fetch("main");
			exit($msg);
		}
	}

	public static function checkVar()
	{
		if (!isset(self::$cmsVersion)) {
			$msg = lang("Error checking permissions");
			$ci = &get_instance();
			$ci->template->assign("content", $msg);
			$msg = $ci->template->fetch("main");
			exit($msg);
		}
	}
}


?>
