<?php
    if (!isset($arg[0])) {
        $view->invoke('404');
    } else {
        $login = $arg[0];
        $user_q = $db->query("SELECT * FROM `user` WHERE `login` = '" . $db->filter($login) . "'");
        if ($db->num_rows($user_q) == 0) {
            $view->invoke('404');
        } else {
            $profile = $db->fetch($user_q);
            $reg_date = other::formatTime($profile['reg_date'], $lang);
            $last_click = other::formatTime($profile['click'], $lang);
            $online = 0;
            if ((time() - $profile['click']) < 600) $online = 1;
            $topics_count = $db->result($db->query("SELECT COUNT(`id`) FROM `topic` WHERE `user` = '$profile[id]'"), 0);
            $comments_count = $db->result($db->query("SELECT COUNT(`id`) FROM `comments` WHERE `user` = '$profile[id]'"), 0);
            $blogs_count = $db->result($db->query("SELECT COUNT(`id`) FROM `blog` WHERE `owner` = '$profile[id]'"), 0);

            $blogs = '';
            if ($blogs_count > 0) {
                $blogs_q = $db->query("SELECT * FROM `blog` WHERE `owner` = '$profile[id]'");
                while ($blog = $db->fetch($blogs_q)) {
                    $blogs .= $view->invoke('users-blog', [
                        'name' => other::filter($blog['name']),
                        'id' => (int) $blog['id'],
                        'translit' => other::filter($blog['translit'])
                    ], true);
                }
            }

            $topics = '';
            if ($topics_count > 0) {
                $topics_q = $db->query("SELECT * FROM `topic` WHERE `user` = '$profile[id]'");
                while ($topic = $db->fetch($topics_q)) {
                    $topics .= $view->invoke('users-topic', [
                        'name' => other::filter($topic['name']),
                        'id' => (int) $topic['id'],
                        'translit' => other::filter($topic['translit'])
                    ], true);
                }
            }

            $view->invoke('profile', [
                'login' => $profile['login'],
                'reg_date' => $reg_date,
                'last_click' => $last_click,
                'topics_count' => $topics_count,
                'comments_count' => $comments_count,
                'blogs_count' => $blogs_count,
                'blogs' => $blogs,
                'topics' => $topics
            ], false, [
                'online' => $online
            ]);
        }
    }