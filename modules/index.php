<?php

    $type = $config['index_type'];

    switch ($type) {
        case 0:
            require 'index_new.php';
            break;
        case 1:
            require 'index_blog.php';
            break;
        case 2:
            require 'index_view.php';
            break;
    }