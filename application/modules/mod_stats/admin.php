<?php

defined("BASEPATH") || exit("No direct script access allowed");
include_once (__DIR__ . DIRECTORY_SEPARATOR . "interfaces" . DIRECTORY_SEPARATOR . "FileImport" . EXT);

class Admin extends BaseAdminController implements FileImport
{
	public $assetManager;
	public $defaultAction = "orders/count";

	public function __construct()
	{
		parent::__construct();
		$lang = new MY_Lang();
		$lang->load("mod_stats");
		ShopController::checkLicensePremium();
		$this->load->helper("file");
		if (($this->input->is_ajax_request() && ($this->uri->uri_string() == "admin/components/cp/mod_stats")) || ($this->uri->uri_string() == "admin/components/init_window/mod_stats")) {
			redirect("admin/components/cp/mod_stats");
		}

		$this->import("classes/ControllerBase" . EXT);
		$this->assetManager = CMSFactory\assetManager::create()->registerScript("functions")->registerScript("d3.v3")->registerScript("nv.d3")->registerStyle("nv.d3")->registerScript("scripts")->registerStyle("styles");

		if (!empty($_SERVER["QUERY_STRING"])) {
			$this->assetManager->setData("queryString", "?" . $_SERVER["QUERY_STRING"]);
		}

		$leftMenu = include (__DIR__ . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR . "left_menu" . EXT);
		$helper = mod_stats\classes\AdminHelper::create();
		$this->assetManager->setData("leftMenu", $leftMenu);
		$this->assetManager->setData("saveSearchResults", $helper->getSetting("save_search_results"));
		$this->assetManager->setData("saveSearchResultsAC", $helper->getSetting("save_search_results_ac"));
		$this->assetManager->setData("saveUsersAttendance", $helper->getSetting("save_users_attendance"));
		$this->assetManager->setData("saveRobotsAttendance", $helper->getSetting("save_robots_attendance"));
		$this->assetManager->setData("CS", $helper->getCurrencySymbol());
	}

	public function index()
	{
		$this->load->model("custom_model");
		$model = $this->custom_model;
		$data = array("countUniqueUsers" => $model->getAllTimeCountUnique(), "countUniqueRobots" => $model->getAllTimeCountUniqueRobots(), "lastPage" => $model->getLastViewedPage());
		$this->assetManager->setData($data)->renderAdmin("start");
	}

	public function orders()
	{
		$this->runControllerAction("orders", func_get_args());
	}

	public function users()
	{
		$this->runControllerAction("users", func_get_args());
	}

	public function products()
	{
		$this->runControllerAction("products", func_get_args());
	}

	public function categories()
	{
		$this->runControllerAction("categories", func_get_args());
	}

	public function search()
	{
		$this->runControllerAction("search", func_get_args());
	}

	public function adminAdd()
	{
		$this->runControllerAction("adminAdd", func_get_args());
		$status = ($_GET["value"] ? "ON" : "OFF");
		lang("save_robots_attendance", "mod_stats");
		lang("save_users_attendance", "mod_stats");
		lang("ave_search_results_ac", "mod_stats");
		lang("save_search_results", "mod_stats");
		$this->lib_admin->log(lang("Statistic", "mod_stats") . ": " . lang($_GET["setting"], "mod_stats") . " - " . $status);
	}

	public function attendance_redirect()
	{
		if (!isset($_GET["type_id"]) || !isset($_GET["id_entity"])) {
			echo "Page not found - No data";
			exit();
		}

		$this->import("classes/Attendance");
		$this->import("classes/AttendanceRedirect");
		$redirect = new AttendanceRedirect();
		$redirect->redirect($_GET["type_id"], $_GET["id_entity"]);
	}

	private function runControllerAction($callerFunctionName, $arguments)
	{
		$controllerName = ucfirst($callerFunctionName) . "Controller";
		$action = array_shift($arguments);
		include (__DIR__ . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . $controllerName . EXT);
		return call_user_func_array(array(new $controllerName($this), $action), $arguments);
	}

	public function import($filePath)
	{
		$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

		if (($ext != "php") && ($ext != "")) {
			return;
		}

		$filePath = str_replace(".php", "", $filePath);
		$reflector = new ReflectionClass($this);
		$fname = pathinfo($reflector->getFileName(), PATHINFO_DIRNAME);
		$filePath = $fname . DIRECTORY_SEPARATOR . str_replace(array("\\", "/"), DIRECTORY_SEPARATOR, $filePath);

		if (strpos($filePath, "*") === false) {
			include_once ($filePath . EXT);
		}
		else {
			$flist = get_filenames(str_replace("*", "", $filePath), true);

			foreach ($flist as $file ) {
				if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) == "php") {
					include_once (str_replace(array("\\", "/"), DIRECTORY_SEPARATOR, $file));
				}
			}
		}
	}

	public function set_input()
	{
		$_SESSION["category"] = $_POST["category"];
	}
}

?>
