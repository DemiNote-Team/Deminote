<?php
    $last_comments = '';
    $new_comments_q = $db->query("SELECT * FROM (
                                    SELECT `comments`.`user`,
                                           `comments`.`time`,
                                           `comments`.`topic`,
                                           `comments`.`id` AS `commid`,
                                           `topic`.`name`,
                                           `topic`.`id`,
                                           `topic`.`translit`,
                                           `topic`.`blog`,
                                           `user`.`login`
                                    FROM `comments`, `topic`, `user`
                                    WHERE
                                      `comments`.`topic` IN (
                                        SELECT DISTINCT `topic`
                                        FROM `comments`
                                        ORDER BY `time` DESC)
                                      AND `topic`.`id` = `comments`.`topic`
                                      AND `user`.`id` = `comments`.`user`
                                    ORDER BY `comments`.`time` DESC
                                  ) `data`
								  GROUP BY `data`.`topic`
  	    						  ORDER BY `data`.`time` DESC
    							  LIMIT $config[items_on_page]");

    while ($comment = $db->fetch($new_comments_q)) {
        $user_login = other::filter($comment['login']);
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