<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    session_name("osmium");
    session_start();
    spl_autoload_register(function($class) {
        if (file_exists(ROOT . '/core/' . $class . '.class.php'))
            include ROOT . '/core/' . $class . '.class.php';
    });

    $db = new database("localhost", "root", "123456", "osmium");
    $user = new user($db);
    $view = new view("templates/default", 'en', $user);
    $config = $db->fetch($db->query("SELECT * FROM `config` LIMIT 1"));
    $content = new content();

    if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
        $view->invoke('head', ['keywords' => $config['keywords'], 'description' => $config['description']]);
        $view->invoke('sidebar', ['title' => 'Osmium CMS']);
        $view->invoke('content-open');
    }