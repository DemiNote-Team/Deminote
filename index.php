<?php
    include 'core/core.php';
    include 'core/head.php';

    $router->route();

    if (!other::checkAjax()) include 'core/foot.php';