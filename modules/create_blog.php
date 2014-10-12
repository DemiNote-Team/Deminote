<?php
    if (!$user->authorized) {
        $view->invoke('404');
    } else {
        if (!$user->canAccess('blogCreate') && $config['create_blog_ability'] == 0) {
            $view->invoke('404');
        } else
            $view->invoke('add-blog-form');
    }