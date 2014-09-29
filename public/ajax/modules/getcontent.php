<?php
    ob_end_clean();
    ob_start();
    $router = new router();
    $router->route($_POST['link']);
    $script = '';
    if ($router->module == 'view' || ($router->module == 'index' && $config['index_type'] == '2'))
        $script .= "var topic = " . ($router->module == 'view' ? other::filter($router->params[0]) : $config['index_view']) . ";\r\n";
    $data = ob_get_contents();
    ob_end_clean();
    other::jsonDie(['success' => 1, 'html' => base64_encode($data), 'script' => $script]);