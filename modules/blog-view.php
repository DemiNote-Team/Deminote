<?php
    $id = (int) $arg['id'];

    $topic_q = $db->query("SELECT `topic`.*, `user`.`login` FROM `topic`, `user` WHERE `topic`.`id` = '$id' AND `user`.`id` = `topic`.`user`");
    $topic = $db->fetch($topic_q);

    function print_comments($id = 0, $topic_id, $deep = 0, $topic_user) {
        global $db, $view, $user;
        $comments_q = $db->query("SELECT `comments`.*, `user`.`login` FROM `comments`, `user` WHERE `comments`.`topic` = '$topic_id' AND `comments`.`reply` = '$id' AND `user`.`id` = `comments`.`user` ORDER BY `time` ASC");
        while ($comment = $db->fetch($comments_q)) {
            $comment_rating = (int) $db->result($db->query("SELECT SUM(`rating`) FROM `comments_rating` WHERE `comment` = '$comment[id]'"), 0);
            if ($comment_rating > 0) $rating_class = 'plus';
            if ($comment_rating < 0) $rating_class = 'minus';
            if ($comment_rating == 0) $rating_class = 'neutral';

            $touchable = 'touchable';
            $plus_passive = '_passive';
            $minus_passive = '_passive';
            if ($user->authorized) {
                $passive_q = $db->query("SELECT `rating`, `id` FROM `comments_rating` WHERE `user` = '" . $user->data['id'] . "' AND `comment` = '" . $comment['id'] . "'");
                if ($db->num_rows($passive_q) > 0) {
                    $passive = $db->fetch($passive_q);
                    if ($passive['rating'] == 1) $plus_passive = '';
                        else $minus_passive = '';
                    $touchable = '';
                }
            }

            $view->invoke('comment-view', [
                'login' => other::filter($comment['login']),
                'text' => other::filter($comment['text']),
                'time' => other::formatTime($comment['time']),
                'deep' => (int) $deep,
                'rating' => $comment_rating,
                'rating_class' => $rating_class,
                'plus_passive' => $plus_passive,
                'minus_passive' => $minus_passive,
                'touchable' => $touchable,
                'id' => (int) $comment['id'],
                'bold' => ($comment['user'] == $topic_user ? 'bold' : ''),
                'me' => (($user->authorized && $comment['user'] == $user->data['id']) ? 'me' : '')
            ]);
            $inside_q = $db->query("SELECT COUNT(`id`) FROM `comments` WHERE `topic` = '$topic_id' AND `reply` = '$id'");
            if ($db->result($inside_q, 0) > 0) print_comments($comment['id'], $topic_id, $deep + 1, $topic_user);
        }
    }

    $blog = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '" . (int) $topic['blog'] . "'"));
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
        'date' => other::formatTime($topic['time']),
        'blog' => $blog['name'],
        'blog_translit' => $blog['translit'],
        'text' => other::filter($topic['text']),
        'id' => (int) $topic['id'],
        'name' => other::filter($topic['translit']),
        'login' => $topic['login'],
        'not_a_link' => (isset($arg['not_a_link']) ? 'not-a-link' : ''),
        'big_text' => (isset($arg['big_text']) ? 'big-text' : ''),
        'rating' => $topic_rating,
        'rating_class' => $rating_class,
        'plus_passive' => $plus_passive,
        'minus_passive' => $minus_passive,
        'touchable' => $touchable
    ]);

    if (!isset($arg['no_comments'])) {
        $comments_count = $db->result($db->query("SELECT COUNT(`id`) FROM `comments` WHERE `topic` = '$id'"), 0);
        $view->invoke('comments-count', ['count' => $comments_count]);
        $comments_q = $db->query("SELECT * FROM `comments` WHERE `topic` = '$id' AND `reply` = 0 ORDER BY `time` ASC");
        print_comments(0, $id, 0, $topic['user']);
        $view->invoke('add-comment-form');
    }