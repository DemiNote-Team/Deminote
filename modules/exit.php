<?php
    unset($_SESSION['session']);
    setcookie('user', '', time() + 3600 * 60 * 60, '/');
    header('Location: /');
    die();