<?php
    if (isset($arg)) $id = (int) $arg[0];

    $topic_q = $db->query("SELECT `topic`.*, `user`.`login` FROM `topic`, `user` WHERE `topic`.`id` = '$id' AND `user`.`id` = `topic`.`user`");
    if ($db->num_rows($topic_q) == 0) {
        $view->invoke('404');
    } else {
        $topic = $db->fetch($topic_q);

        function print_comments($id = 0, $topic_id, $deep = 0, $topic_user, $blogid) {
            global $db, $view, $user, $lang;
            $rating_class = 0;
            $comments_q = $db->query("SELECT `comments`.*, `user`.`login` FROM `comments`, `user` WHERE `comments`.`topic` = '$topic_id' AND `comments`.`reply` = '$id' AND `user`.`id` = `comments`.`user` ORDER BY `time` ASC");
            while ($comment = $db->fetch($comments_q)) {
                $comment_rating = (int) $db->result($db->query("SELECT SUM(`rating`) FROM `rating` WHERE `type` = '1' AND `item` = '$comment[id]'"), 0);
                if ($comment_rating > 0) $rating_class = 'plus';
                if ($comment_rating < 0) $rating_class = 'minus';
                if ($comment_rating == 0) $rating_class = 'neutral';

                $touchable = 'touchable';
                $plus_passive = '_passive';
                $minus_passive = '_passive';
                if ($user->authorized) {
                    $passive_q = $db->query("SELECT `rating`, `id` FROM `rating` WHERE `type` = '1' AND `user` = '" . $user->data['id'] . "' AND `item` = '" . $comment['id'] . "'");
                    if ($db->num_rows($passive_q) > 0) {
                        $passive = $db->fetch($passive_q);
                        if ($passive['rating'] == 1) $plus_passive = '';
                            else $minus_passive = '';
                        $touchable = '';
                    }
                }

                if ($user->authorized) $moderator = ($db->num_rows($db->query("SELECT * FROM `moderators` WHERE `user` = '" . $user->data['id'] . "' AND `blog` = '$blogid'")) ? 1 : 0);
                    else $moderator = -1;

                $view->invoke('comment-view', [
                    'login' => other::filter($comment['login']),
                    'text' => ($comment['removed'] ? '<div class="gray">' . $lang->getData()['removed_comment'] . '</div>' : other::processOutput($comment['text'])),
                    'time' => other::formatTime($comment['time'], $lang),
                    'deep' => (int) $deep,
                    'rating' => $comment_rating,
                    'rating_class' => $rating_class,
                    'plus_passive' => $plus_passive,
                    'minus_passive' => $minus_passive,
                    'touchable' => $touchable,
                    'id' => (int) $comment['id'],
                    'bold' => ($comment['user'] == $topic_user ? 'bold' : ''),
                    'me' => (($user->authorized && $comment['user'] == $user->data['id']) ? 'me' : ''),
                ], 0, ['moderator' => $moderator]);
                $inside_q = $db->query("SELECT COUNT(`id`) FROM `comments` WHERE `topic` = '$topic_id' AND `reply` = '$id'");
                if ($db->result($inside_q, 0) > 0) print_comments($comment['id'], $topic_id, $deep + 1, $topic_user, $blogid);
            }
        }

        $blog = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '" . (int) $topic['blog'] . "'"));
        $topic_rating = (int) $db->result($db->query("SELECT SUM(`rating`) FROM `rating` WHERE `type` = '0' AND `item` = '$topic[id]'"), 0);
        if ($topic_rating > 0) $rating_class = 'plus';
        if ($topic_rating < 0) $rating_class = 'minus';
        if ($topic_rating == 0) $rating_class = 'neutral';

        $touchable = 'touchable';
        $plus_passive = '_passive';
        $minus_passive = '_passive';
        if ($user->authorized) {
            $passive_q = $db->query("SELECT `rating`, `id` FROM `rating` WHERE `type` = '0' AND `user` = '" . $user->data['id'] . "' AND `item` = '" . $topic['id'] . "'");
            if ($db->num_rows($passive_q) > 0) {
                $passive = $db->fetch($passive_q);
                if ($passive['rating'] == 1) $plus_passive = '';
                else $minus_passive = '';
                $touchable = '';
            }
        }

        if ($user->authorized) $moderator = ($db->num_rows($db->query("SELECT * FROM `moderators` WHERE `user` = '" . $user->data['id'] . "' AND `blog` = '$topic[blog]'")) ? 1 : 0);
            else $moderator = 0;
        if ($user->authorized && $topic['user'] == $user->data['id']) $moderator = 1;
        if ($user->canAccess('topicEdit')) $moderator = 1;

        $view->invoke('topic', [
            'title' => other::filter($topic['name']),
            'date' => other::formatTime($topic['time'], $lang),
            'blog' => $blog['name'],
            'blog_translit' => $blog['translit'],
            'text' => other::processOutput($topic['text']),
            'id' => (int) $topic['id'],
            'name' => other::filter($topic['translit']),
            'login' => $topic['login'],
            'not_a_link' => 'not-a-link',
            'big_text' => 'big-text',
            'rating' => $topic_rating,
            'rating_class' => $rating_class,
            'plus_passive' => $plus_passive,
            'minus_passive' => $minus_passive,
            'touchable' => $touchable,
            'blog_id' => (int) $topic['blog'],
            'read_more' => 'none'
        ], false, ['moderator' => $moderator]);

        if (!isset($arg['no_comments'])) {
            $comments_count = $db->result($db->query("SELECT COUNT(`id`) FROM `comments` WHERE `topic` = '$id'"), 0);
            $view->invoke('comments-count', ['count' => $comments_count]);
            $comments_q = $db->query("SELECT * FROM `comments` WHERE `topic` = '$id' AND `reply` = 0 ORDER BY `time` ASC");
            $view->invoke('comments-open');
            print_comments(0, $id, 0, $topic['user'], $blog['id']);
            $view->invoke('comments-close');
            $view->invoke('add-comment-form');
        }
    }