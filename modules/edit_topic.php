<?php
    $error = 0;
    if (!$user->authorized) {
        $error = 1;
    }
    if (!isset($arg[2])) {
        $error = 1;
    }
    $id = (int) $arg[1];
    $topic_q = $db->query("SELECT * FROM `topic` WHERE `id` = '$id'");
    if ($db->num_rows($topic_q) == 0) {
        $error = 1;
    }

    if ($error) {
        $view->invoke('404');
    } else {
        $topic = $db->fetch($topic_q);
        $owner = ($topic['user'] == $user->data['id']);
        $moderator = $db->num_rows($db->query("SELECT * FROM `moderators` WHERE `blog` = '$topic[blog]' AND `user` = '" . $user->data['id'] . "'"));
        $access = $user->canAccess('topicEdit');
        if (!$owner && !$moderator && !$access) {
            $view->invoke('404');
        } else {
            $blog_list_q = $db->query("SELECT `id`, `name`, `closed` FROM `blog`");
            $blog_list = '';
            while ($blog = $db->fetch($blog_list_q)) {
                if ($topic['blog'] == $blog['id']) $selected = 'selected';
                    else $selected = '';

                $blog_list .= $view->invoke('blog-select-option', [
                    'value' => (int) $blog['id'],
                    'name' => other::filter($blog['name']),
                    'closed' => ($blog['closed'] ? '({{:closed}})' : ''),
                    'selected' => $selected
                ], true);
            }

            $view->invoke('topic-edit', [
                'id' => $topic['id'],
                'name' => other::filter($topic['name']),
                'text' => other::processOutput(other::filter($topic['text'], true)),
                'options' => $blog_list
            ]);
        }
    }