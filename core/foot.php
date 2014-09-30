<?php
    $view->invoke('content-close');

    $blog_list = '';
    $blog_list_q = $db->query("SELECT * FROM `blog`");
    while ($blog = $db->fetch($blog_list_q)) {
        $name = other::filter($blog['name']);
        $translit = other::filter($blog['translit']);
        $id = (int) $blog['id'];
        $blog_list .= $view->invoke('blog-name', [
            'name' => $name,
            'translit' => $translit,
            'id' => $id,
            'selected' => 0
        ], true);
    }

    $last_comments = '';
    ob_start();
    content::get('new_comments');
    $last_comments = ob_get_contents();
    ob_end_clean();

    $view->invoke('right', [
        'login' => ($user->authorized ? $user->data['login'] : 'undefined'),
        'blog_list' => $blog_list,
        'last_comments' => $last_comments
    ]);
    $view->invoke('foot', ['generation' => round((microtime(true) - START_TIME) * 1000, 2)]);