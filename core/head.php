<?php

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
        header('Location: /');
        die();
    }

    if (isset($_SESSION['vk_data'])) {
        $vk_data = $_SESSION['vk_data'];
    }

    if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
        $view->invoke('head', [
            'keywords' => $config['keywords'],
            'description' => $config['description'],
            'script' => (isset($vk_data) ? ('var vkdata = \'' . $vk_data . '\';') : ''),
            'vk_app_id' => $config['vk_app_id']
        ]);
        $view->invoke('sidebar', ['title' => 'Osmium CMS']);
        $view->invoke('content-open');
    }