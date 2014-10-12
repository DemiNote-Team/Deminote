<?php
    if (!$_POST['id']) other::jsonDie(['error' => 1, 'desc' => 'no_id']);
    $comment = $db->power_query("SELECT * FROM `comments` WHERE `id` = '" . (int) $_POST['id'] . "'");
    $topic = $db->power_query("SELECT * FROM `topic` WHERE `id` = '" . (int) $comment['id'] . "'");
    $moderator_q = $db->query("SELECT * FROM `moderators` WHERE `blog` = '$topic[blog]' AND `user` = '" . $user->data['id'] . "'");
    if (!$user->canAccess('commentRemove') && $db->num_rows($moderator_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'no_access']);
    $db->query("UPDATE `comments` SET `removed` = '1' WHERE `id` = '" . (int) $_POST['id'] . "'");
    other::jsonDie(['success' => 1]);