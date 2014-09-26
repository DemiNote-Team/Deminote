<?php
    include 'core/core.php';

    $content->get('index', [
        'type' => $config['index_type'],
        'index_blog' => $config['index_blog'],
        'index_view' => $config['index_view']
    ]);

    include 'core/foot.php';