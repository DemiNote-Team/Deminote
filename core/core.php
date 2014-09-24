<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
	include_once ROOT . '/core/view.class.php';
	//include_once ROOT . '/core/db.class.php';

	$view = new View("templates/default");
	//$db = new database("localhost", "root", "", "osmium");