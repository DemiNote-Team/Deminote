<?php
    if (!$user->authorized) {
        $view->invoke('404');
    } else {
        $blog_list_q = $db->query("SELECT `id`, `name`, `closed` FROM `blog`");
        $blog_list = '';
        while ($blog = $db->fetch($blog_list_q)) {
            $blog_list .= $view->invoke('blog-select-option', [
                'value' => (int) $blog['id'],
                'name' => other::filter($blog['name']),
                'closed' => ($blog['closed'] ? '({{:closed}})' : '')
            ], true);
        }

        $view->invoke('add-topic-form', [
            'options' => $blog_list
        ]);
    }