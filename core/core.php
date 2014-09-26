<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    session_name("osmium");
    session_start();
	include_once ROOT . '/core/view.class.php';
	include_once ROOT . '/core/database.class.php';

    class user {
        public $authorized = false;
    }

    $user = new user();
	$view = new View("templates/default", $user);
	$db = new database("localhost", "root", "123456", "osmium");
    $config = $db->fetch($db->query("SELECT * FROM `config` LIMIT 1"));

    $view->invoke('head');
    $view->invoke('sidebar', ['title' => 'Osmium CMS']);
    $view->invoke('content-open');