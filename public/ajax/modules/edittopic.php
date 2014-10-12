<?php
    if (!$user->authorized) other::jsonDie(['error' => '1', 'desc' => 'not_authorized']);
    if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['blog'])) other::jsonDie(['error' => '1', 'desc' => 'incorrect_params']);
    $id = (int) $_POST['id'];
    $topic_q = $db->query("SELECT * FROM `topic` WHERE `id` = '$id'");
    if ($db->num_rows($topic_q) == 0) other::jsonDie(['error' => '1', 'desc' => 'incorrect_topic']);
    $blog_id = (int) $_POST['blog'];
    $blog_q = $db->query("SELECT * FROM `blog` WHERE `id` = '$blog_id'");
    if ($db->num_rows($blog_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'incorrect_blog']);
    $blog = $db->fetch($blog_q);
    $moderator_q = $db->query("SELECT * FROM `moderators` WHERE `user` = '" . $user->data['id'] . "' AND `blog` = '$blog_id'");
    if ($blog['closed'] && !$user->canAccess('topicCreate') && $db->num_rows($moderator_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'closed_blog']);
    $topic = $db->fetch($topic_q);
    $owner = ($topic['user'] == $user->data['id']);
    $moderator = $db->num_rows($db->query("SELECT * FROM `moderators` WHERE `blog` = '$topic[blog]' AND `user` = '" . $user->data['id'] . "'"));
    $access = $user->canAccess('topicEdit');
    if (!$owner && !$moderator && !$access) other::jsonDie(['error' => '1', 'desc' => 'no_access']);
    $text = trim($_POST['text']);
    $title = trim($_POST['title']);
    if (other::length($text) < 10) other::jsonDie(['error' => 1, 'desc' => 'message_too_small']);
    if (other::length($title) < 3) other::jsonDie(['error' => 1, 'desc' => 'title_too_small']);
    if (other::length($title) > 64) other::jsonDie(['error' => 1, 'desc' => 'title_too_big']);

    $title = $db->filter($title);
    $text = $db->filter($text);

    $db->query("UPDATE `topic` SET `name` = '$title', `text` = '$text', `blog` = '$blog_id', `translit` = '" . other::translit($title) . "' WHERE `id` = '$id'");
    other::jsonDie(['success' => 1, 'id' => $id, 'translit' => other::translit($title)]);