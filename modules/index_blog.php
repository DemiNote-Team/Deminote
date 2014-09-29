<?php
    $id = (int) $config['index_blog'];
    $blog = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '" . (int) $id . "'"));
    $view->invoke('page-title', ['title' => '{{:new_topics}} - {{name}}', 'name' => other::filter($blog['name'])]);
    $topics_count = $db->result($db->query("SELECT COUNT(`id`) FROM `topic` WHERE `blog` = '" . (int) $id . "'"), 0);
    if (isset($_GET['page'])) $page = (int) $_GET['page'];
        else $page = 1;
    $page = max(1, max($topics_count, $page));
    $top = $config['topics_on_page'];
    $limit = $top * $page - $top;

    $topics_q = $db->query("SELECT `topic`.*, `user`.`login` FROM `topic`, `user` WHERE `topic`.`blog` = '" . (int) $id . "' AND `user`.`id` = `topic`.`user` ORDER BY `time` DESC LIMIT $limit, $top");
    while ($topic = $db->fetch($topics_q)) {
        $view->invoke('topic', [
            'title' => other::filter($topic['name']),
            'date' => other::formatTime($topic['time']),
            'blog' => $blog['name'],
            'blog_translit' => $blog['translit'],
            'text' => other::filter($topic['text']),
            'id' => (int) $topic['id'],
            'name' => other::filter($topic['translit']),
            'login' => $topic['login']
        ]);
    }