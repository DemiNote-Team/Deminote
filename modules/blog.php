<?php
    $id = (int) $arg[0];
    $blog = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '" . (int) $id . "'"));
    $view->invoke('page-title', ['title' => '{{:new_topics}}: {{name}}', 'name' => other::filter($blog['name'])]);
    $topics_count = $db->result($db->query("SELECT COUNT(`id`) FROM `topic` WHERE `blog` = '" . (int) $id . "'"), 0);
    if (isset($_GET['page'])) $page = (int) $_GET['page'];
    else $page = 1;
    $page = max(1, max($topics_count, $page));
    $top = $config['topics_on_page'];
    $limit = $top * $page - $top;

    $topics_q = $db->query("SELECT `topic`.*, `user`.`login` FROM `topic`, `user` WHERE `topic`.`blog` = '" . (int) $id . "' AND `user`.`id` = `topic`.`user` ORDER BY `time` DESC LIMIT $limit, $top");

    if ($db->num_rows($topics_q) == 0) $view->invoke('no-topics');

    while ($topic = $db->fetch($topics_q)) {

        $topic_rating = (int) $db->result($db->query("SELECT SUM(`rating`) FROM `topic_rating` WHERE `topic` = '$topic[id]'"), 0);
        if ($topic_rating > 0) $rating_class = 'plus';
        if ($topic_rating < 0) $rating_class = 'minus';
        if ($topic_rating == 0) $rating_class = 'neutral';

        $touchable = 'touchable';
        $plus_passive = '_passive';
        $minus_passive = '_passive';
        if ($user->authorized) {
            $passive_q = $db->query("SELECT `rating`, `id` FROM `topic_rating` WHERE `user` = '" . $user->data['id'] . "' AND `topic` = '" . $topic['id'] . "'");
            if ($db->num_rows($passive_q) > 0) {
                $passive = $db->fetch($passive_q);
                if ($passive['rating'] == 1) $plus_passive = '';
                else $minus_passive = '';
                $touchable = '';
            }
        }

        $view->invoke('topic', [
            'title' => other::filter($topic['name']),
            'date' => other::formatTime($topic['time'], $lang),
            'blog' => $blog['name'],
            'blog_translit' => $blog['translit'],
            'text' => other::filter($topic['text']),
            'id' => (int) $topic['id'],
            'name' => other::filter($topic['translit']),
            'login' => $topic['login'],
            'rating' => $topic_rating,
            'touchable' => 'touchable',
            'plus_passive' => $plus_passive,
            'minus_passive' => $minus_passive,
            'blog_id' => (int) $topic['blog']
        ]);
    }