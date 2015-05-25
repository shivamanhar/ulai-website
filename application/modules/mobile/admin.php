<?php

defined("BASEPATH") || exit("No direct script access allowed");

class Admin extends BaseAdminController
{
	public function __construct()
	{
		parent::__construct();
		ShopController::checkLicensePremium();
		$lang = new MY_Lang();
		$lang->load("mobile");
	}

	public function get_settings()
	{
		$settings = $this->db->where("name", "mobile")->get("components")->result_array();
		$this->settings = $settings[0]["settings"];
	}

	public function index()
	{
		$this->get_settings();
		CMSFactory\assetManager::create()->setData(array("mobileTemplates" => $this->_getMobileTemplatesList()));
		CMSFactory\assetManager::create()->setData(unserialize($this->settings))->renderAdmin("main");
	}

	public function update()
	{
		$sql = "update components set settings = '" . serialize($_POST) . "' where name = 'mobile'";
		$this->db->query($sql);
		showMessage(lang("Data saved", "mobile"));
	}

	protected function _getMobileTemplatesList()
	{
		$paths = array();
		$this->load->helper("directory");
		$dirs = array("./application/" . getModContDirName("shop") . "/shop/templates/*", "./templates/*/shop");

		foreach ($dirs as $dir ) {
			$result = glob($dir, GLOB_ONLYDIR);

			if (is_array($result)) {
				foreach ($result as $key => $val ) {
					if (!stristr($val, "_mobile")) {
						unset($result[$key]);
					}
				}

				$paths = array_merge($paths, $result);
			}
		}

		if (sizeof(0 < $paths)) {
			return $paths;
		}

		return false;
	}
}

?>
