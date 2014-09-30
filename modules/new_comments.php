<?php
    $last_comments = '';
    $new_comments_q = $db->query("SELECT `comments`.`user`,
                                         `comments`.`time`,
                                         `comments`.`topic`,
                                         `topic`.`name`,
                                         `topic`.`id`,
                                         `topic`.`translit`,
                                         `topic`.`blog`
                                  FROM `comments`, `topic`, `user`
                                  WHERE
                                    `comments`.`topic` = `topic`.`id`
                                  GROUP BY  `topic`.`id`
                                  ORDER BY `comments`.`time` ASC
                                  LIMIT $config[topics_on_page]");

    while ($comment = $db->fetch($new_comments_q)) {
        $last_comment = $db->fetch($db->query("SELECT `comments`.`topic`, `user`.`login` FROM `user`, `comments` WHERE `comments`.`topic` = '$comment[topic]' AND `user`.`id` = `comments`.`user` ORDER BY `comments`.`time` DESC"));
        $user_login = other::filter($last_comment['login']);
        $topic_name = other::filter($comment['name']);
        $topic_id = (int) $comment['id'];
        $comment_time = other::formatTime((int) $comment['time'], $lang);
        $translit = other::filter($comment['translit']);
        $topic_blog = (int) $comment['blog'];
        $blog_info = $db->fetch($db->query("SELECT * FROM `blog` WHERE `id` = '$topic_blog'"));
        $blog_translit = other::filter($blog_info['translit']);
        $blog_name = other::filter($blog_info['name']);
        $last_comments .= $view->invoke('last-comment', [
            'topic_name' => $topic_name,
            'topic_id' => $topic_id,
            'translit' => $translit,
            'user_login' => $user_login,
            'comment_time' => $comment_time,
            'blog_name' => $blog_name,
            'blog_translit' => $blog_translit
        ]);
    }