<?php

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
        header('Location: /');
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

    if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
        $view->invoke('head', [
            'keywords' => $config['keywords'],
            'description' => $config['description'],
            'script' => $script,
            'vk_app_id' => $config['vk_app_id']
        ]);
        $view->invoke('sidebar', ['title' => 'Osmium CMS']);
        $view->invoke('content-open');
    }