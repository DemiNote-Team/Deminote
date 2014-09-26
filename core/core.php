<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    session_name("osmium");
    session_start();
    include_once ROOT . '/core/view.class.php';
    include_once ROOT . '/core/database.class.php';
    include_once ROOT . '/core/user.class.php';

    $db = new database("localhost", "root", "123456", "osmium");
    $user = new user($db);
    $view = new View("templates/default", 'en', $user);
    $config = $db->fetch($db->query("SELECT * FROM `config` LIMIT 1"));

    $view->invoke('head');
    $view->invoke('sidebar', ['title' => 'Osmium CMS']);
    $view->invoke('content-open');