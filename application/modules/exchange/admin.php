<?php

defined("BASEPATH") || exit("No direct script access allowed");

class Admin extends BaseAdminController
{
	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopController::checkLicensePremium();
		$this->locale = MY_Controller::getCurrentLocale();
		$lang = new MY_Lang();
		$lang->load("exchange");
		$this->tempDir = "./uploads/cmlTemp";

		if (!is_dir($this->tempDir)) {
			mkdir($this->tempDir);
		}
	}

	public function index()
	{
		$settings = $this->get1CSettings();
		$this->template->add_array(array("settings" => $settings, "statuses" => $this->get_orders_statuses()));
		$this->display_tpl("settings");
	}

	private function get1CSettings()
	{
		$config = $this->db->where("identif", "exchange")->get("components")->row_array();

		if (empty($config)) {
			return false;
		}

		return unserialize($config["settings"]);
	}

	private function get_orders_statuses()
	{
		return $this->db->query("SELECT * FROM `shop_order_statuses`
		JOIN `shop_order_statuses_i18n` ON shop_order_statuses.id=shop_order_statuses_i18n.id
		WHERE `locale`='" . $this->locale . "'")->result_array();
	}

	private function display_tpl($file = "")
	{
		$file = realpath(dirname(__FILE__)) . "/templates/admin/" . $file;
		$this->template->show("file:" . $file);
	}

	public function update_settings()
	{
		$for_update = $this->input->post("1CSettings");

		if ($for_update) {
			$this->load->library("form_validation");
			$this->form_validation->set_rules("1CSettings[filesize]", lang("Size of the file being loaded at the same time", "exchange"), "integer|required");
			$this->form_validation->set_rules("1CSettings[validIP]", lang("IP server 1C", "exchange"), "valid_ip|required");
			$config["zip"] = $for_update["zip"];
			$config["filesize"] = $for_update["filesize"];
			$config["validIP"] = $for_update["validIP"];
			$config["login"] = $for_update["login"];
			$config["password"] = $for_update["password"];
			$config["usepassword"] = $for_update["usepassword"];
			$config["userstatuses"] = $for_update["statuses"];
			$config["autoresize"] = $for_update["autoresize"];
			$config["debug"] = $for_update["debug"];
			$config["email"] = $for_update["email"];
			$config["brand"] = $for_update["brand"];
			$config["userstatuses_after"] = $for_update["userstatuses_after"];
			$config["backup"] = $for_update["backup"];

			if ($this->form_validation->run() == false) {
				showMessage(validation_errors(), "", "r");
			}
			else {
				$this->db->where("identif", "exchange")->update("components", array("settings" => serialize($config)));
				$this->lib_admin->log(lang("1C settings was edited", "exchange"));
				showMessage(lang("Settings saved", "exchange"));
			}
		}
	}

	public function startImagesResize()
	{
		ShopCore::app()->SWatermark->updateWatermarks(true);
		showMessage(lang("Images saved", "exchange"));
	}

	public function setAdditionalCats()
	{
		$products = $this->db->select("shop_products.category_id, shop_products.id, shop_category.full_path_ids, shop_category.parent_id")->join("shop_category", "shop_category.id = shop_products.category_id")->get("shop_products")->result();
		$this->db->truncate("shop_product_categories");

		foreach ($products as $product ) {
			foreach (unserialize($product->full_path_ids) as $fpi ) {
				$this->db->set("category_id", $fpi);
				$this->db->set("product_id", $product->id);

				try {
					$this->db->insert("shop_product_categories");

					if ($this->db->_error_message()) {
						throw new Exception("product $product->id already in this category $fpi");
					}
				} catch (Exception $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
			}

			if (!in_array($product->parent_id, unserialize($product->full_path_ids))) {
				$this->db->set("category_id", $product->parent_id);
				$this->db->set("product_id", $product->id);
				$this->db->insert("shop_product_categories");
			}

			if (!in_array($product->category_id, unserialize($product->full_path_ids))) {
				$this->db->set("category_id", $product->category_id);
				$this->db->set("product_id", $product->id);
				$this->db->insert("shop_product_categories");
			}
		}

		$this->lib_admin->log(lang("1C additional categories was started", "exchange"));
		redirect("/admin/components/cp/exchange");
	}

	public function clear($type)
	{
		switch ($type) {
		case "error":
			write_file($this->tempDir . "error_log.txt", "");
		case "log":
			write_file($this->tempDir . "log.txt", "");
		case "time":
			write_file($this->tempDir . "time.txt", "");
		}
	}

	public function log($type)
	{
		switch ($type) {
		case "error":
			$txt = read_file($this->tempDir . "error_log.txt");
			$txt = explode("\n", $txt);

			if (40000 < count($txt)) {
				$txt = array_slice($txt, count($txt) - 20000);
			}

			foreach ($txt as $value ) {
				preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $value, $ip);
				$text .= preg_replace("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", "<br><b>" . $ip[0] . "</b>", $value) . "<br>";
			}

			$title = lang("Errors log", "exchange");
		case "log":
			$txt = read_file($this->tempDir . "log.txt");
			$txt = explode("\n", $txt);

			if (40000 < count($txt)) {
				$txt = array_slice($txt, count($txt) - 20000);
			}

			foreach ($txt as $value ) {
				$text .= $value . "<br>";
			}

			$title = lang("Query log", "exchange");
		case "time":
			$txt = read_file($this->tempDir . "time.txt");
			$txt = explode("\n", $txt);

			if (40000 < count($txt)) {
				$txt = array_slice($txt, count($txt) - 20000);
			}

			foreach ($txt as $value ) {
				$text .= $value . "<br>";
			}

			$title = lang("Time log", "exchange");
		}

		lang("Time log", "exchange")->log(lang("1C log was cleared", "exchange"));
		CMSFactory\assetManager::create()->setData("type", $type)->setData("text", trim($text, "<br>"))->setData("title", $title)->renderAdmin("Log");
	}
}

?>
