<?php
    if (!$user->authorized) other::jsonDie(['error' => '1', 'desc' => 'not_authorized']);
    if (!$user->canAccess('blogCreate') && $config['create_blog_ability'] == 0) other::jsonDie(['error' => '1', 'desc' => 'no_access']);
    if (!isset($_POST['closed']) || !isset($_POST['title'])) other::jsonDie(['error' => '1', 'desc' => 'incorrect_params']);
    $closed = ((int) $_POST['closed'] == 1 ? 1 : 0);
    $title = trim($_POST['title']);
    if (other::length($title) < 3) other::jsonDie(['error' => 1, 'desc' => 'title_too_small']);
    if (other::length($title) > 64) other::jsonDie(['error' => 1, 'desc' => 'title_too_big']);

    $db->query("INSERT INTO `blog`
                (`name`, `translit`, `closed`, `owner`) values
                ('" . $db->filter($title) . "', '" . other::translit($title) . "', '$closed', '" . $user->data['id'] . "')");
    $newid = $db->insert_id();
    other::jsonDie(['success' => 1, 'id' => $newid, 'translit' => other::translit($title)]);