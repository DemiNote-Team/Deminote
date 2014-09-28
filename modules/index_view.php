<?php
    $id = (int) $config['index_view'];

    content::get('blog-view', ['id' => $id, 'not_a_link' => true]);