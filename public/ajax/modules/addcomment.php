<?php
    if (!isset($_POST['text']) || !isset($_POST['topic'])) other::jsonDie(['error' => 1, 'desc' => 'no_params']);
    if (!$user->authorized) other::jsonDie(['error' => 1, 'desc' => 'not_authorized']);
    $rating_q = [
        $db->result($db->query("SELECT SUM(`rating`.`rating`) FROM `comments`, `rating` WHERE `type` = '1' AND `rating`.`item` = `comments`.`id` AND `comments`.`user` = '" . $user->data['id'] . "'"), 0),
        $db->result($db->query("SELECT SUM(`rating`.`rating`) FROM `topic`, `rating` WHERE `type` = '0' AND `rating`.`item` = `topic`.`id` AND `topic`.`user` = '" . $user->data['id'] . "'"), 0)
    ];
    $rating = $rating_q[0] + $rating_q[1];
    if ($rating < -20) other::jsonDie(['error' => 1, 'desc' => 'rating_too_low']);
    $text = trim($_POST['text']);
    $topic = (int) $_POST['topic'];

    if (other::length(strip_tags($text)) < 1) other::jsonDie(['error' => 1, 'desc' => 'message_too_small']);
    if (other::length($text) > 10000) other::jsonDie(['error' => 1, 'desc' => 'message_too_big']);

    $topic_q = $db->query("SELECT `id`, `closed` FROM `topic` WHERE `id` = '" . $topic . "'");
    if ($db->num_rows($topic_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'incorrect_topic']);
    $topic = $db->fetch($topic_q);
    if ($topic['closed'] == 1) other::jsonDie(['error' => 1, 'desc' => 'closed_topic']);

    $reply = 0;
    if (isset($_POST['reply'])) {
        $reply = (int) $_POST['reply'];
        $reply_q = $db->query("SELECT * FROM `comments` WHERE `id` = '$reply' AND `topic` = '$topic[id]'");
        if ($db->num_rows($reply_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'incorrect_reply']);
    }

    $db->query("INSERT INTO `comments` (`user`, `topic`, `time`, `text`, `reply`)
                values
                ('" . $user->data['id'] . "', '$topic[id]', '" . time() . "', '" . $db->filter($text) . "', '$reply')");
    $newid = $db->insert_id();
    other::jsonDie(['success' => 1, 'hash' => 'comment-' . $newid]);