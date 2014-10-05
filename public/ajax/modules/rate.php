<?php
    if (!$user->authorized) other::jsonDie(['error' => 1, 'desc' => 'not-authorized']);
    if (!isset($_POST['type']) || !isset($_POST['id']) || !isset($_POST['rating'])) other::jsonDie(['error' => 1, 'desc' => 'no-params']);
    $type = ($_POST['type'] == 1 ? 1 : 0);
    $rating = ($_POST['rating'] == 1 ? 1 : -1);
    $id = (int) $_POST['id'];
    $already_q = $db->query("SELECT * FROM `rating` WHERE `type` = '$type' AND `item` = '$id' AND `user` = '" . $user->data['id'] . "'");
    if ($db->num_rows($already_q) != 0) other::jsonDie(['error' => 1, 'desc' => 'already']);
    if ($type == 0) $isset_q = $db->query("SELECT * FROM `topic` WHERE `id` = '$id'");
        else $isset_q = $db->query("SELECT * FROM `comments` WHERE `id` = '$id'");
    $item = $db->fetch($isset_q);
    if ($item['user'] == $user->data['id']) other::jsonDie(['error' => 1, 'desc' => 'your-item']);
    if ($db->num_rows($isset_q) == 0) other::jsonDie(['error' => 1, 'desc' => 'wrong-id']);
    $db->query("INSERT INTO `rating` (`type`, `user`, `rating`, `item`) values ('$type', '" . $user->data['id'] . "', '$rating', '$id')");
    $new = $db->result($db->query("SELECT SUM(`rating`) FROM `rating` WHERE `type` = '$type' AND `item` = '$id'"), 0);
    other::jsonDie(['success' => 1, 'rating' => $new]);