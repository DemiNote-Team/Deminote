<?php

    $type = $config['index_type'];

    switch ($type) {
        case 0:
            require ROOT . '/modules/index_new.php';
            break;
        case 1:
            require ROOT . '/modules/index_blog.php';
            break;
        case 2:
            require ROOT . '/modules/index_view.php';
            break;
    }