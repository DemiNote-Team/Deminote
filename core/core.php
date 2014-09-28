<?php
    define('START_TIME', microtime(true));
    ob_start('ob_gzhandler');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    define('ROOT', $_SERVER["DOCUMENT_ROOT"]);
    session_name('osmium');
    session_start();
    spl_autoload_register(function($class) {
        if (file_exists(ROOT . '/core/' . $class . '.class.php'))
            include ROOT . '/core/' . $class . '.class.php';
    });

    $db = new database("localhost", "root", "123456", "osmium");
    $config = $db->fetch($db->query("SELECT * FROM `config` LIMIT 1"));
    $user = new user($db);
    $view = new view("templates/" . $config['template'], (isset($_SESSION['lang']) ? $_SESSION['lang'] : $config['default_lang']), $config['default_lang'], $user);