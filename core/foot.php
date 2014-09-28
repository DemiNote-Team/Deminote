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
    $new_comments_q = $db->query("SELECT `comments`.`user`, `comments`.`time`, `topic`.`name`, `topic`.`id`, `topic`.`translit`, `topic`.`blog`, `user`.`login` FROM `comments`, `topic`, `user` WHERE `comments`.`topic` = `topic`.`id` AND `user`.`id` = `comments`.`user` ORDER BY `time` DESC");
    while ($comment = $db->fetch($new_comments_q)) {
        $topic_name = other::filter($comment['name']);
        $topic_id = (int) $comment['id'];
        $comment_time = other::formatTime((int) $comment['time']);
        $user_login = other::filter($comment['login']);
        $translit = other::filter($comment['translit']);
        $topic_blog = (int) $comment['blog'];
        $blog_info = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '$topic_blog'"));
        $blog_translit = other::filter($blog_info['translit']);
        $blog_name = other::filter($blog_info['name']);
        $last_comments .= $view->invoke('last-comment', [
            'topic_name' => $topic_name,
            'topic_id' => $topic_id,
            'translit' => $translit,
            'user_login' => $user_login,
            'comment_time' => $comment_time,
            'blog_name' => $blog_name,
            'blog_translit' => $blog_translit
        ], true);
    }

    $view->invoke('right', [
        'login' => ($user->authorized ? $user->data['name'] : 'undefined'),
        'blog_list' => $blog_list,
        'last_comments' => $last_comments
    ]);
    $view->invoke('foot', ['generation' => round((microtime(true) - START_TIME) * 1000, 2)]);