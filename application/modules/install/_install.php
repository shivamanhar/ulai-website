<?php


if (!defined("BASEPATH")) {
	exit("No direct script access allowed");
}
class Install extends MY_Controller
{
	public $host = "";
	public $useSqlFile = "sql.sql";
	private $exts = false;
	private $loadedExt = false;

	public function __construct()
	{
		parent::__construct();
		$lang = new MY_Lang();
		$lang->load("install");
		$lang->load("main");
		$this->load->helper("string");
		$this->load->helper("form_csrf");
		$this->host = reduce_multiples($this->host);
		$this->loadedExt = get_loaded_extensions();
	}

	public function index()
	{
		if (moduleExists("shop")) {
			$data = array("content" => $this->load->view("license_shop", array("next_link" => $this->host . "/install/step_1"), true));
		}
		else {
			$data = array("content" => $this->load->view("license", array("next_link" => $this->host . "/install/step_1"), true));
		}

		$this->load->view("main", $data);
	}

	public function step_1()
	{
		$result = true;
		$dir_array = array("./application/config/config.php" => "ok", "./system/cache" => "ok", "./captcha/" => "ok", "./system/cache/templates_c" => "ok", "./uploads/" => "ok", "./uploads/images" => "ok", "./uploads/files" => "ok", "./uploads/media" => "ok");

		foreach ($dir_array as $k => $v ) {
			if (is_really_writable($k) === true) {
				$dir_array[$k] = "ok";
			}
			else {
				$dir_array[$k] = "err";
				$result = false;
			}
		}

		$allow_params = array("register_globals" => "ok", "safe_mode" => "ok");

		foreach ($allow_params as $k => $v ) {
			if (ini_get($k) == 1) {
				$allow_params[$k] = "warning";
			}
			else {
				$allow_params[$k] = "ok";
			}
		}

		if (moduleExists("shop")) {
			if (strnatcmp(phpversion(), "5.4") != -1) {
				$allow_params["PHP version >= 5.4"] = "ok";
			}
			else {
				$allow_params["PHP version >= 5.4"] = "err";
				$result = false;
			}
		}
		else if (strnatcmp(phpversion(), "5.3.4") != -1) {
			$allow_params["PHP version >= 5.3.4"] = "ok";
		}
		else {
			$allow_params["PHP version >= 5.3.4"] = "err";
			$result = false;
		}

		$exts = array("curl" => "ok", "json" => "ok", "mbstring" => "ok", "iconv" => "ok", "gd" => "ok", "zlib" => "ok", "gettext" => "ok", "soap" => "ok");

		if (moduleExists("shop")) {
		}

		foreach ($exts as $k => $v ) {
			if ($this->checkExtensions($k) === false) {
				$exts[$k] = "warning";

				if ($k == "json") {
					$exts[$k] = "err";
					$result = false;
				}

				if ($k == "mbstring") {
					$exts[$k] = "err";
					$result = false;
				}

				if ($k == "gettext") {
					$exts[$k] = "err";
					$result = false;
				}

				if ($k == "curl") {
					$exts[$k] = "err";
					$result = false;
				}
				
			}
		}

		$locales = array("en_US" => "ok", "ru_RU" => "ok");

		foreach ($locales as $locale => $v ) {
			if (!setlocale(LC_ALL, $locale . ".utf8", $locale . ".utf-8", $locale . ".UTF8", $locale . ".UTF-8", $locale . ".utf-8", $locale . ".UTF-8", $locale)) {
				if (!setlocale(LC_ALL, "")) {
					$locales[$locale] = "warning";
				}
			}
		}

		$data = array("dirs" => $dir_array, "need_params" => $need_params, "allow_params" => $allow_params, "exts" => $exts, "locales" => $locales, "next_link" => $this->_get_next_link($result, 1));
		$this->_display($this->load->view("step_1", $data, true));
	}

	/**
     * Check is extension loaded
     * @param string $name extension name
     */
	private function checkExtensions($name = "")
	{
		if (in_array($name, $this->loadedExt)) {
			return true;
		}

		return false;
	}

	/**
     * @deprecated since version 4.6
     * @param type $name
     * @return boolean
     */
	private function _get_ext($name = "")
	{
		if ($this->exts === false) {
			ob_start();
			phpinfo(INFO_MODULES);
			$this->exts = ob_get_contents();
			ob_end_clean();
			$this->exts = strip_tags($this->exts, "<h2><th><td>");
		}

		$result = preg_match("/<h2>.*$name.*<\/h2>/", $this->exts, $m);

		if (count($m) == 0) {
			return false;
		}

		return true;
	}

	public function step_2()
	{
		$this->load->library("Form_validation");
		$this->form_validation->set_error_delimiters("", "");
		$result = true;
		$other_errors = "";

		if (0 < count($_POST)) {
			$this->form_validation->set_rules("site_title", lang("Site name", "install"), "required");
			$this->form_validation->set_rules("db_host", lang("Host", "install"), "required");
			$this->form_validation->set_rules("db_user", lang("Database username", "install"), "required");
			$this->form_validation->set_rules("db_name", lang("Database name", "install"), "required");
			$this->form_validation->set_rules("admin_pass", lang("Administrator password", "install"), "required|min_length[5]");
			$this->form_validation->set_rules("admin_mail", lang("Administrator E-mail", "install"), "required|valid_email");
			$this->form_validation->set_rules("lang_sel", lang("Language", "install"), "required");

			if ($this->form_validation->run() == false) {
				$result = false;
			}
			else if ($this->test_db() == false) {
				$other_errors .= lang("Database connection error", "install") . ".<br/>";
				$result = false;
			}

			if ($result == true) {
				$this->make_install();
			}
		}

		$data = array("next_link" => $this->_get_next_link($result, 2), "other_errors" => $other_errors, "host" => $this->host, "sqlFileName" => $this->useSqlFile);
		$this->_display($this->load->view("step_2", $data, true));
	}

	private function make_install()
	{
		$this->load->helper("file");
		$this->load->helper("url");
		$db_server = $this->input->post("db_host");
		$db_user = $this->input->post("db_user");
		$db_pass = $this->input->post("db_pass");
		$db_name = $this->input->post("db_name");
		$link = mysql_connect($db_server, $db_user, $db_pass);
		$db_sel = mysql_select_db($db_name);
		$tables = array();
		$sql = "SHOW TABLES FROM $db_name";

		if ($result = mysql_query($sql, $link)) {
			while ($row = mysql_fetch_row($result)) {
				$tables[] = $row[0];
			}
		}

		if (0 < count($tables)) {
			foreach ($tables as $t ) {
				$sql = "DROP TABLE $db_name.$t";

				if (!mysql_query($sql, $link)) {
					exit("MySQL error. Can\'t delete $db_name.$t");
				}
			}
		}

		mysql_query("SET NAMES `utf8`;", $link);
		$sqlFileData = read_file(dirname(__FILE__) . "/" . $this->useSqlFile);
		$queries = explode(";\n", $sqlFileData);

		foreach ($queries as $q ) {
			$q = trim($q);

			if ($q != "") {
				mysql_query($q . ";", $link);
			}
		}

		mysql_query("UPDATE `settings_i18n` SET `name`='" . mysql_real_escape_string($this->input->post("site_title")) . "' ", $link);
		mysql_query("UPDATE `settings_i18n` SET `short_name`='" . mysql_real_escape_string($this->input->post("site_title")) . "' ", $link);
		mysql_query("UPDATE `settings` SET `lang_sel`='" . mysql_real_escape_string($this->input->post("lang_sel")) . "' ", $link);

		if ($this->input->post("product_samples") != "on") {
			mysql_query("TRUNCATE `category`;", $link);
			mysql_query("INSERT INTO `category` (`id`, `name`, `url`, `per_page`, `order_by`) VALUES ('1', 'test', 'test', '1', 'publish_date');", $link);
			mysql_query("UPDATE `settings` SET `main_type`='category', `main_page_cat`='1';", $link);
			mysql_query("TRUNCATE `comments`;", $link);
			mysql_query("TRUNCATE `content`;", $link);
			mysql_query("TRUNCATE `content_fields`;", $link);
			mysql_query("TRUNCATE `content_fields_data`;", $link);
			mysql_query("TRUNCATE `content_fields_groups_relations`;", $link);
			mysql_query("TRUNCATE `content_field_groups`;", $link);
			mysql_query("TRUNCATE `gallery_albums`;", $link);
			mysql_query("TRUNCATE `gallery_category`;", $link);
			mysql_query("TRUNCATE `gallery_images`;", $link);
			mysql_query("TRUNCATE `menus`;", $link);
			mysql_query("TRUNCATE `menus_data`;", $link);
			mysql_query("TRUNCATE `support_comments`;", $link);
			mysql_query("TRUNCATE `support_departments`;", $link);
			mysql_query("TRUNCATE `support_tickets`;", $link);
			mysql_query("TRUNCATE `tags`;", $link);
			mysql_query("TRUNCATE `content_permissions`;", $link);
			mysql_query("TRUNCATE `content_tags`;", $link);
			mysql_query("TRUNCATE `logs`;", $link);
			$this->load->helper("file");

			if (moduleExists("shop")) {
				delete_files("./uploads/shop", true);
				mysql_query("UPDATE `settings` SET `main_type`='module', `main_page_module`='shop';", $link);
				mysql_query("TRUNCATE `shop_category`;", $link);
				mysql_query("TRUNCATE `shop_category_i18n`;", $link);
				mysql_query("TRUNCATE `shop_comulativ_discount`;", $link);
				mysql_query("TRUNCATE `shop_discounts`;", $link);
				mysql_query("TRUNCATE `shop_gifts`;", $link);
				mysql_query("TRUNCATE `shop_kit`;", $link);
				mysql_query("TRUNCATE `shop_kit_product`;", $link);
				mysql_query("TRUNCATE `shop_notifications`;", $link);
				mysql_query("TRUNCATE `shop_notification_statuses`;", $link);
				mysql_query("TRUNCATE `shop_notification_statuses_i18n`;", $link);
				mysql_query("TRUNCATE `shop_orders`;", $link);
				mysql_query("TRUNCATE `shop_orders_products`;", $link);
				mysql_query("TRUNCATE `shop_orders_status_history`;", $link);
				mysql_query("TRUNCATE `shop_products`;", $link);
				mysql_query("TRUNCATE `shop_products_i18n`;", $link);
				mysql_query("TRUNCATE `shop_product_categories`;", $link);
				mysql_query("TRUNCATE `shop_product_images`;", $link);
				mysql_query("TRUNCATE `shop_product_properties`;", $link);
				mysql_query("TRUNCATE `shop_product_properties`;", $link);
				mysql_query("TRUNCATE `shop_product_properties_categories`;", $link);
				mysql_query("TRUNCATE `shop_product_properties_data`;", $link);
				mysql_query("TRUNCATE `shop_product_properties_data_i18n`;", $link);
				mysql_query("TRUNCATE `shop_product_properties_i18n`;", $link);
				mysql_query("TRUNCATE `shop_product_variants`;", $link);
				mysql_query("TRUNCATE `shop_product_variants_i18n`;", $link);
				mysql_query("TRUNCATE `shop_banners`;", $link);
				mysql_query("TRUNCATE `shop_banners_i18n`;", $link);
				mysql_query("TRUNCATE `shop_brands`;", $link);
				mysql_query("TRUNCATE `shop_brands_i18n`;", $link);
				mysql_query("TRUNCATE `shop_spy`;", $link);
				mysql_query("TRUNCATE `shop_warehouse`;", $link);
				mysql_query("TRUNCATE `shop_warehouse_data`;", $link);
			}

			delete_files("./uploads/gallery", true);
			delete_files("./uploads/images", true);
		}

		$this->writeDatabaseConfig(array("hostname" => $this->input->post("db_host"), "username" => $this->input->post("db_user"), "password" => $this->input->post("db_pass"), "database" => $this->input->post("db_name")));
		$this->writeCmsConfig(array("is_installed" => "TRUE"));
		$this->load->database();
		$this->load->helper("cookie");
		delete_cookie("autologin");
		$this->load->library("DX_Auth");
		$admin_pass = crypt($this->dx_auth->_encode($this->input->post("admin_pass")));
		$admin_login = $this->input->post("admin_login");
		$admin_mail = $this->input->post("admin_mail");
		$admin_created = date("Y-m-d H:i:s", time());
		$sql = "INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `email`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login`, `created`, `modified`)\n                        VALUES (1, 1, 'Administrator', '$admin_pass', '$admin_mail', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '0000-00-00 00:00:00', '$admin_created', '0000-00-00 00:00:00'); ";
		mysql_query($sql, $link);
		$this->cache->delete_all();
		$this->writeDatabaseConfig(array("hostname" => $this->input->post("db_host"), "username" => $this->input->post("db_user"), "password" => $this->input->post("db_pass"), "database" => $this->input->post("db_name")));
		$this->dx_auth->login($this->input->post("admin_login"), $this->input->post("admin_pass"), true);
		header("Location: " . $this->host . "/install/done");
	}

	public function done()
	{
		chmod(getModulePath("install") . "/install.php", 511);
		rename(getModulePath("install") . "/install.php", getModulePath("install") . "/_install.php");
		chmod(getModulePath("install") . "/install.php", 493);
		$this->_display($this->load->view("done", "", true));
	}

	/**
     * 
     * @param array $data
     *  - hostname
     *  - username
     *  - password
     *  - database
     */
	public function writeDatabaseConfig($data)
	{
		$configFile = APPPATH . "config/database.php";
		$this->load->helper("file");
		$configContent = read_file($configFile);
		$basePattern = "/db\['default'\]\['__KEY__'\] = '([a-zA-Z0-9\-\_]*)';/";
		$baseReplacement = "db['default']['__KEY__'] = '__VALUE__';";

		foreach ($data as $key => $value ) {
			$keyPattern = str_replace("__KEY__", $key, $basePattern);
			$replacement = str_replace(array("__KEY__", "__VALUE__"), array($key, $value), $baseReplacement);
			$configContent = preg_replace($keyPattern, $replacement, $configContent);
		}

		if (!write_file($configFile, $configContent)) {
			exit(lang("Error writing file config.php", "install"));
		}
	}

	private function _get_next_link($result = false, $step = 1)
	{
		if ($result === true) {
			$next_link = $this->host . "/install/step_" . ($step + 1);
		}
		else {
			$next_link = $this->host . "/install/step_" . $step;
		}

		return $next_link;
	}

	public function _display($content)
	{
		$data = array("content" => $content);
		$this->load->view("main", $data);
	}

	private function test_db()
	{
		$result = true;
		$db_server = $this->input->post("db_host");
		$db_user = $this->input->post("db_user");
		$db_pass = $this->input->post("db_pass");
		$db_name = $this->input->post("db_name");
		$link = mysql_connect($db_server, $db_user, $db_pass);
		$db_sel = mysql_select_db($db_name);
		if (($link == false) || ($db_sel == false)) {
			$result = false;
		}

		mysql_close($link);
		return $result;
	}

	public function writeCmsConfig($data)
	{
		$configFile = APPPATH . "config/cms.php";
		$this->load->helper("file");
		$configContent = read_file($configFile);
		$basePattern = "/config\['__KEY__'\]\s+= ([a-zA-Z0-9\-\_]*);/";
		$baseReplacement = "config['__KEY__'] = __VALUE__;";

		foreach ($data as $key => $value ) {
			$keyPattern = str_replace("__KEY__", $key, $basePattern);
			$replacement = str_replace(array("__KEY__", "__VALUE__"), array($key, $value), $baseReplacement);
			$configContent = preg_replace($keyPattern, $replacement, $configContent);
		}

		if (!file_put_contents($configFile, $configContent)) {
			exit(lang("Error writing file config.php", "install"));
		}
	}

	public function change_language()
	{
		$language = $this->input->post("language");

		if ($language) {
			$this->session->set_userdata("language", $language);
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}
}


?>
