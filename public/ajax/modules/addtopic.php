<?php
    if (!isset($_POST['text']) || !isset($_POST['blog']) || !isset($_POST['title'])) other::jsonDie(['error' => 1, 'desc' => 'no_params']);
    if (!$user->authorized) other::jsonDie(['error' => 1, 'desc' => 'not_authorized']);
    if (!$config['create_topic_ability'] && $user->data['group'] == 1) other::jsonDie(['error' => 1, 'desc' => 'blog_closed']);
    if (time() - $user->data['last_topic_time'] < $config['new_topic_interval']) other::jsonDie(['error' => 1, 'desc' => 'not_time_yet']);
    $blog_id = (int) $_POST['blog'];
    $blog_q = $db->query("SELECT * FROM `blog` WHERE `id` = '$blog_id'");
    if ($db->num_rows($blog_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'incorrect_blog']);
    $blog = $db->fetch($blog_q);
    $moderator_q = $db->query("SELECT * FROM `moderators` WHERE `user` = '" . $user->data['id'] . "' AND `blog` = '$blog_id'");
    if ($blog['closed'] && !$user->canAccess('topicCreate') && $db->num_rows($moderator_q) == 0 && $blog['owner'] != $user->data['id']) other::jsonDie(['error' => 1, 'desc' => 'closed_blog']);
    $text = trim($_POST['text']);
    $title = trim($_POST['title']);
    if (other::length($text) < 10) other::jsonDie(['error' => 1, 'desc' => 'message_too_small']);
    if (other::length($title) < 3) other::jsonDie(['error' => 1, 'desc' => 'title_too_small']);
    if (other::length($title) > 64) other::jsonDie(['error' => 1, 'desc' => 'title_too_big']);

    $db->query("INSERT INTO `topic` (`user`, `name`, `text`, `time`, `blog`, `translit`)
                values
                ('" . $user->data['id'] . "', '" . $db->filter($title) ."', '" . $db->filter($text) . "', '" . time() . "', '$blog_id', '" . other::translit($title) . "')");
    $newid = $db->insert_id();
    other::jsonDie(['success' => 1, 'id' => $newid, 'translit' => other::translit($title)]);