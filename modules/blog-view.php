<?php
    $id = (int) $arg['id'];

    $topic_q = $db->query("SELECT `topic`.*, `user`.`login` FROM `topic`, `user` WHERE `topic`.`id` = '$id' AND `user`.`id` = `topic`.`user`");
    $topic = $db->fetch($topic_q);

    $view->invoke('page-title', ['title' => '{{:browsing_topic}}']);

    $blog = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '" . (int) $topic['blog'] . "'"));
    $view->invoke('blog', [
        'title' => other::filter($topic['name']),
        'date' => other::formatTime($topic['time']),
        'blog' => $blog['name'],
        'blog_translit' => $blog['translit'],
        'text' => other::filter($topic['text']),
        'id' => (int) $topic['id'],
        'name' => other::filter($topic['translit']),
        'login' => $topic['login'],
        'not_a_link' => (isset($arg['not_a_link']) ? 'not-a-link' : '')
    ]);