<?php

class ShopAdminSystem extends ShopAdminController
{
	private $checkedFields = array("name", "url", "prc", "var", "cat", "num");
	private $languages;
	private $uploadDir = BACKUPFOLDER;
	private $csvFileName = "product_csv_1.csv";
	private $uplaodedFileInfo = array();

	public function __construct()
	{
		parent::__construct();
		ShopController::checkVar();
		ShopAdminController::checkVarAdmin();
		$this->languages = $this->db->get("languages")->result();
		$this->load->helper("file");
		ini_set("max_execution_time", 9000000);
		set_time_limit(9000000);
	}

	public function import()
	{
		if (count($_FILES)) {
			$this->saveCSVFile();
		}

		if (count($_POST["attributes"]) && $_POST["csvfile"]) {
			$importSettings = $this->cache->fetch("ImportExportCache");
			if (empty($importSettings) || ($importSettings["withBackup"] != $this->input->post("withBackup"))) {
				$this->cache->store("ImportExportCache", array("withBackup" => $this->input->post("withBackup")), "25920000");
			}

			$result = ImportCSV\ImportBootstrap::create()->withBackup()->startProcess()->resultAsString();
			echo json_encode($result);
		}
		else if (!$_FILES) {
			$customFields = SPropertiesQuery::create()->orderByPosition()->find();
			$cFieldsTemp = $customFields->toArray();
			$cFields = array();

			foreach ($cFieldsTemp as $f ) {
				$cFields[] = $f["CsvName"];
			}

			$importSettings = $this->cache->fetch("ImportExportCache");
			$this->template->assign("withBackup", $importSettings["withBackup"]);
			$this->configureImportProcess();
			$this->template->registerJsFile(getModulePath("shop") . "admin/templates/system/importExportAdmin.js", "after");
			$this->render("import", array("customFields" => SPropertiesQuery::create()->orderByPosition()->find(), "languages" => $this->languages, "cFields" => $cFields, "currencies" => SCurrenciesQuery::create()->orderByIsDefault()->find(), "attributes" => ImportCSV\BaseImport::create()->makeAttributesList()->possibleAttributes, "checkedFields" => $this->checkedFields));
		}

		$this->cache->delete_all();

		if ($_POST["withResize"]) {
			$result[content] = explode("/", trim($result["content"][0]));
			MediaManager\Image::create()->resizeById($result["content"])->resizeByIdAdditional($result["content"], true);
		}

		if ($_POST["withCurUpdate"]) {
			Currency\Currency::create()->checkPrices();
		}
	}

	public function getCategoryProperties()
	{
		$cats = $_POST["selectedCats"];

		if (0 < count($cats)) {
			$properties = SPropertiesQuery::create()->join("ShopProductPropertiesCategories")->where("ShopProductPropertiesCategories.CategoryId IN ?", $cats)->joinWithI18n()->distinct()->orderByPosition()->find();
		}
		else {
			$properties = SPropertiesQuery::create()->joinWithI18n()->orderByPosition()->find();
		}

		$result = "";

		foreach ($properties as $p ) {
			$result .= "<div class=\"serverResponse\">\n            <span class=\"frame_label no_connection eattrcol\">\n            <span class=\"niceCheck b_n\">\n            <input type=\"checkbox\" value=\"1\" class=\"eattr\" name=\"attribute[" . $p->getCsvName() . "]\" />\n            </span>\n            " . $p->getName() . "\n            </span>\n            </div>";
		}

		if (empty($result)) {
			$result = "<p class=\"serverResponse\">" . lang("Could not find any properties", "admin") . "</p>";
		}

		echo $result;
	}

	public function export()
	{
		$export = new ShopExportDataBase(array("attributes" => $_POST["attribute"], "attributesCF" => $_POST["cf"], "import_type" => trim($_POST["import_type"]), "delimiter" => trim($_POST["delimiter"]), "enclosure" => trim($_POST["enclosure"]), "encoding" => trim($_POST["encoding"]), "currency" => trim($_POST["currency"]), "languages" => trim($_POST["language"]), "selectedCats" => $_POST["selectedCats"]));
		$export->getDataArray();

		if ($export->hasErrors() == false) {
			if (!$this->input->is_ajax_request()) {
				if (trim($_POST["formed_file_type"]) != "0") {
					$this->downloadFile($_POST["formed_file_type"]);
					return;
				}

				$this->createFile($_POST["type"], $export);
				$this->downloadFile($_POST["type"]);
				return;
			}

			if (false !== $this->createFile($_POST["type"], $export)) {
				echo $_POST["type"];
				return;
			}

			echo "Error";
		}
		else {
			echo $this->processErrors($export->getErrors());
		}
	}

	protected function downloadFile($type = "csv")
	{
		if (!in_array($type, array("csv", "xls", "xlsx"))) {
			return;
		}

		$file = "products." . $type;
		$path = $this->uploadDir . $file;

		if (file_exists($path)) {
			$this->load->helper("download");
			$data = file_get_contents($path);

			if ($type == "csv") {
				header("Content-type: text/csv");
			}

			force_download($file, $data);
		}
	}

	protected function createFile($type, $export)
	{
		switch ($type) {
            case "xls":
                return $export->saveToExcelFile($this->uploadDir, "Excel5");
                break;
            case "xlsx":
                return $export->saveToExcelFile($this->uploadDir, "Excel2007");
                break;
            default: // csv
                return $export->saveToCsvFile($this->uploadDir);
        }		
	}

	private function saveCSVFile()
	{
		$this->takeFileName();
		$this->load->library("upload", array("overwrite" => true, "upload_path" => $this->uploadDir, "allowed_types" => "*"));
		$fileExt = pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

		if (!in_array($fileExt, array("csv", "xls", "xlsx"))) {
			echo json_encode(array("error" => lang("Wrong file type. Only csv|xls|xlsx")));
			return;
		}

		if ($this->upload->do_upload("userfile")) {
			$data = $this->upload->data();
			if (($data["file_ext"] === ".xls") || ($data["file_ext"] === ".xlsx")) {
				$this->convertXLStoCSV($data["full_path"]);
				unlink(BACKUPFOLDER . $data["client_name"]);
			}
			else {
				rename(BACKUPFOLDER . str_replace(" ", "_", $data["client_name"]), BACKUPFOLDER . $this->csvFileName);
			}

			$this->configureImportProcess();
		}
		else {
			echo json_encode(array("error" => $this->upload->display_errors()));
		}
	}

	private function mimePreFilter($fileKey)
	{
		$mimes = &get_mimes();
		$fileName = $_FILES[$fileKey]["name"];
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$fileTmpPath = $_FILES[$fileKey]["tmp_name"];
		$mimeType = mime_content_type($_FILES[$fileKey]["tmp_name"]);
		$neededMimes = false;

		foreach ($mimes as $ext_ => $possibleMimes ) {
			if ($ext == $ext_) {
				$neededMimes = $possibleMimes;
			}
		}

		if ($neededMimes == false) {
			echo json_encode(array("error" => lang("System error - uknown extention", "admin")));
			return false;
		}

		if (is_array($neededMimes) && in_array($mimeType, $neededMimes, true)) {
			return true;
		}

		if ($mimeType === $neededMimes) {
			return true;
		}

		echo json_encode(array("error" => lang("File cannot be uploaded, because file with such extention <br /> can not have those mime-type. Mime: ", "admin") . $mimeType));
		return false;
	}

	private function convertXLStoCSV($excel_file = "")
	{
		$excellib = getModulePath("shop");
		include ($excellib . "classes/PHPExcel.php");
		include ($excellib . "classes/PHPExcel/IOFactory.php");
		include ($excellib . "classes/PHPExcel/Writer/Excel2007.php");
		$objReader = PHPExcel_IOFactory::createReaderForFile($excel_file);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($excel_file);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(NULL, true, true, true);

		foreach ($sheetData as $i ) {
			foreach ($i as $j ) {
				$toPrint .= "\"" . str_replace("\"", "\"\"", $j) . "\";";
			}

			$toPrint = rtrim($toPrint, ";") . PHP_EOL;
		}

		$filename = $this->csvFileName;
		fopen(BACKUPFOLDER . $filename, "w+");

		if (is_writable(BACKUPFOLDER . $filename)) {
			if (!$handle = fopen(BACKUPFOLDER . $filename, "w+")) {
				echo json_encode(array("error" => ImportCSV\Factor::ErrorFolderPermission));
				exit();
			}

			write_file(BACKUPFOLDER . $filename, $toPrint);
			fclose($handle);
		}
		else {
			showMessage(lang("The file $filename is not writable", "admin"));
		}
	}

	private function configureImportProcess($vector = true)
	{
		if (file_exists($this->uploadDir . $this->csvFileName)) {
			$file = fopen($this->uploadDir . $this->csvFileName, "r");
			$row = array_diff(fgetcsv($file, 10000, ";", "\""), array(NULL));
			fclose($file);
			$this->getFilesInfo();

			foreach ($this->uplaodedFileInfo as $file ) {
				$uploadedFiles[str_replace(".", "", $file["name"])] = date("d.m.y H:i", $file["date"]);
			}

			if ($vector && $this->input->is_ajax_request() && $_FILES) {
				echo json_encode(array("success" => true, "row" => $row, "attributes" => ImportCSV\BaseImport::create()->attributes, "filesInfo" => $uploadedFiles));
			}
			else {
				$this->template->add_array(array("rows" => $row, "attributes" => ImportCSV\BaseImport::create()->makeAttributesList()->possibleAttributes, "filesInfo" => $uploadedFiles));
			}
		}
	}

	private function takeFileName()
	{
		$fileNumber = (in_array($_POST["csvfile"], array(1, 2, 3)) ? intval($_POST["csvfile"]) : 1);
		$this->csvFileName = "product_csv_$fileNumber.csv";
	}

	public function getAttributes()
	{
		$this->takeFileName();
		$this->configureImportProcess(false);
		$this->render("import_attributes");
	}

	private function getFilesInfo($dir = NULL)
	{
		$dir = ($dir == NULL ? $this->uploadDir : $dir);

		foreach (get_filenames($dir) as $file ) {
			if (strpos($file, "roduct_csv_")) {
				$this->uplaodedFileInfo[] = get_file_info($this->uploadDir . $file);
			}
		}
	}

	public function downExpUsers()
	{
		$this->load->helper("download");
		$data = file_get_contents("./application/backups/exportUsers.csv");
		force_download("exportUsers.csv", $data);
		redirect("/admin/components/run/shop/users/index#export");
	}

	public function exportUsers()
	{
		if (empty($_POST["export"])) {
			showMessage(lang("You do not choose", "admin"), "", "r");
			exit();
		}

		if ($_POST["export"] == "csv") {
			$model = SUserProfileQuery::create()->find();
			$fp = fopen("./application/backups/exportUsers.csv", "w");

			if ($fp === false) {
				showMessage(lang("Can not create file (No Rights)", "admin"), "", "r");
				exit();
			}

			foreach ($model as $u ) {
				fwrite($fp, "\"" . $u->getUserEmail() . "\";\"" . $u->getName() . "\"\n");
			}

			fseek($fp, 0);
			fclose($fp);
			$name = "./application/backups/exportUsers.csv";

			if (file_exists($name)) {
				echo "<script>document.location.href = '" . site_url("/admin/components/run/shop/system/downExpUsers") . "'</script>";
			}

			showMessage(lang("Export successfully", "admin"));
		}
		else if ($_POST["export"] == "monkey") {
			$settings = &ShopCore::app()->SSettings;
			$model = SUserProfileQuery::create()->find();
			if ($settings->adminMessageMonkey && $settings->adminMessageMonkeylist) {
				$this->load->library("Mailchimp", $settings->adminMessageMonkey, "mail_chimp");
				$batch = NULL;

				foreach ($model as $u ) {
					$obj = new stdClass();
					$ObjHandler = new stdClass();
					$obj->email = $u->getUserEmail();
					$ObjHandler->FNAME = $u->getName();
					$batch[] = array("EMAIL" => $obj, "merge_vars" => $ObjHandler);
				}

				$this->mail_chimp->lists->batchSubscribe($settings->adminMessageMonkeylist, $batch, false, true, true);
				pjax("/admin/components/run/shop/users/index");
				showMessage(lang("Export successfully", "admin"));
			}
			else {
				pjax("/admin/components/run/shop/users/index#export");
				showMessage(lang("No configuration key or<br /> key account list on Mailchimp", "admin") . $settings->adminMessageMonkeylist, "", "r");
			}
		}
	}

	protected function processErrors(array $errors)
	{
		$result = "";

		foreach ($errors as $err ) {
			$result .= $err . "<br/>";
		}

		return "<p class=\"errors\">" . $result . "</p>";
	}

	protected function checkFileExtension($fileName)
	{
		$parts = explode(".", $fileName);

		if (end($parts) != "csv") {
			return false;
		}

		return true;
	}

	protected function downloadFile2($type = "csv")
	{
		if (!in_array($type, array("csv", "xls", "xlsx"))) {
			return;
		}

		$file = "exportUsers." . $type;
		$path = "./application/backups/exportUsers.csv";

		if (file_exists($path)) {
			$this->load->helper("download");
			$data = file_get_contents($path);

			if ($type == "csv") {
				header("Content-type: text/csv");
			}

			force_download($file, $data);
		}
	}
}


?>
