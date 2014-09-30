<?php
    include '../../core/core.php';
    if (!isset($_POST['method'])) other::jsonDie(['error' => '1', 'desc' => 'no-method']);
    if (!file_exists('modules/' . $_POST['method'] . '.php')) other::jsonDie(['error' => '1', 'desc' => 'wrong-method']);
    include_once 'modules/' . $_POST['method'] . '.php';