<?php

class SLicense
{
	public function __construct()
	{
		//echo "1";
		exit();
	}

	public function __callStatic($name, $arguments)
	{
	/*	echo "Calling object method '$name' " . implode(", ", $arguments) . "
";
		var_dump(__DIR__ . "/lic/License.php");
		include_once (__DIR__ . "/lic/License.php");
		exit();*/
	}
}


?>
