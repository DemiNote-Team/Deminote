<?php
    unset($_SESSION['session']);
    setcookie('session', 'none', time() + 3600 * 60 * 60, '/');
    setcookie('osmium', 'none', time() + 3600 * 60 * 60, '/');
    header('Location: /');
    die();