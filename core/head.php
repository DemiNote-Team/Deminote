<?php

    if (isset($_GET['lang'])) {
        if (!preg_match("@^([a-z]{2,10})$@sui", $_GET['lang'])) {
            header('Location: /');
            die();
        }
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

    $t_lang = (isset($_SESSION['lang']) ? $_SESSION['lang'] : $config['default_lang']);
    if (!file_exists(ROOT . '/templates/' . $config['template'] . '/lang/' . $t_lang . '.ini')) $t_lang = 'ru';
    $langdata = parse_ini_file(ROOT . '/templates/' . $config['template'] . '/lang/' . $t_lang . '.ini');
    foreach ($langdata as $key => $value) {
        $langdata[$key] = other::filter($value);
    }
    $langfile = json_encode($langdata);
    $script .= "\r\n        var lang = '$langfile';";

    if (!other::checkAjax()) {
        $view->invoke('head', [
            'keywords' => $config['keywords'],
            'description' => $config['description'],
            'script' => $script,
            'vk_app_id' => $config['vk_app_id'],
            'google_client_id' => $config['google_app_id']
        ]);
        $view->invoke('sidebar', ['title' => 'Osmium CMS']);
        $view->invoke('content-open');
    }