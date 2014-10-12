<?php
    if ($arg[0] == 'topic') include_once 'create_topic.php';
    else if ($arg[0] == 'blog') include_once 'create_blog.php';
    else $view->invoke('404');