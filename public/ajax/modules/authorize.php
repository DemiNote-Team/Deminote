<?php
    $login = $_POST['login'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    $error = [];
    $error_answer = ['error' => 1, 'desc' => 'error'];
    $success_answer = ['success' => 1];

    $login_q = $db->query("SELECT * FROM `user` WHERE `login` = '" . $db->filter($login) . "'");
    if ($db->num_rows($login_q) == 0) $error[] = 'wrong-password';
    if ($_SESSION['captcha'] != mb_strtoupper($captcha, 'UTF-8')) $error[] = 'wrong-captcha' . $_SESSION['captcha'];
    $user = $db->fetch($login_q);
    if ($user['password'] != other::hash($password)) $error[] = 'wrong-password';

    if (count($error) > 0) {
        $_SESSION['captcha'] = md5(time() . mt_rand(17, 49) . md5(mt_rand(0, 494949)));
        $error_answer['desc'] = $error[0];
        die(json_encode($error_answer));
    } else {
        $session = other::generateSession();
        $_SESSION['session'] = $session;
        $db->query("UPDATE `user` SET `session` = '$session' WHERE `id` = '$user[id]'");
        setcookie('session', $session, time() + 3600 * 60 * 60, '/');
        $success_answer['session'] = $session;
        die(json_encode($success_answer));
    }