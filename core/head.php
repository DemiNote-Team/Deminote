<?php

    $router = new router();

    if (isset($_GET['lang'])) {
        if (!preg_match("@^([a-z]{2,10})$@sui", $_GET['lang'])) {
            header('Location: /');
            die();
        }
        $_SESSION['lang'] = $_GET['lang'];
        header('Location: ' . explode('?', $_SERVER['REQUEST_URI'])[0]);
        die();
    }

    $script = '';

    if (isset($_SESSION['vk_data'])) {
        $vk_data = $_SESSION['vk_data'];
        $script = 'oauthdata = \'' . $vk_data . '\';';
    }

    if (isset($_SESSION['google_data'])) {
        $google_data = $_SESSION['google_data'];
        $script = 'oauthdata = \'' . $google_data . '\';';
    }

    $langdata = $lang->getData();
    foreach ($langdata as $key => $value) {
        $langdata[$key] = other::filter($value);
    }
    $langfile = json_encode($langdata);
    $script .= "\r\n        var lang = '$langfile';";

    if ($router->module == 'view' || ($router->module == 'index' && $config['index_type'] == '2'))
        $script .= "\r\n        var topic = " . ($router->module == 'view' ? other::filter($router->params[0]) : $config['index_view']) . ";";

    if (!other::checkAjax()) {
        $view->invoke('head', [
            'keywords' => $config['keywords'],
            'description' => $config['description'],
            'script' => $script,
            'vk_app_id' => $config['vk_app_id'],
            'google_client_id' => $config['google_app_id'],
            'title' => 'Deminote'
        ]);
        $view->invoke('sidebar', ['title' => 'Deminote']);
        $view->invoke('content-open');
    }
