<?php

    $type = $config['index_type'];

    switch ($type) {
        case 'new':
            include ROOT . '/modules/index_new.php';
            break;
        case 'blog':
            $id = $config['index_blog'];
            include ROOT . '/modules/index_blog.php';
            break;
        case 'view':
            $id = $config['index_view'];
            include ROOT . '/modules/index_view.php';
            break;
    }