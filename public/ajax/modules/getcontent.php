<?php
    ob_end_clean();
    ob_start();
    $router = new router();
    $router->route($_POST['link']);
    $data = ob_get_contents();
    ob_end_clean();

    ob_start();
    content::get('new_comments');
    $new_comments = ob_get_contents();
    ob_end_clean();

    other::jsonDie([
        'success' => 1,
        'html' => base64_encode($data),
        'new_comments' => base64_encode($new_comments),
        'gen' => round((microtime(true) - START_TIME) * 1000, 2)
    ]);