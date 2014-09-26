<?php

    switch ($type) {
        case 'new':
            include ROOT . '/modules/index_new.php';
            break;
        case 'blog':
            $id = $index_blog;
            include ROOT . '/modules/index_blog.php';
            break;
        case 'view':
            $id = $index_view;
            include ROOT . '/modules/index_view.php';
            break;
    }