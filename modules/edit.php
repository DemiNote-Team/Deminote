<?php
    if ($arg[0] == 'topic') include_once 'edit_topic.php';
    else if ($arg[0] == 'blog') include_once 'edit_blog.php';
    else content::get('404');