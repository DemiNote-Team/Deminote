<?php
    include '../../core/core.php';
    if (!isset($_POST['method'])) die('{"error": 1, "desc": "no-method"}');
    if (!file_exists('modules/' . $_POST['method'] . '.php')) die('{"error": 1, "desc": "wrong-method"}');
    include_once 'modules/' . $_POST['method'] . '.php';