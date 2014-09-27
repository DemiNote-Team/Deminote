<?php
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['captcha'];
    $captcha = $_POST['captcha'];
    $oauth_id = '0';
    $error = [];

    if (isset($_SESSION['vk_data'])) {
        $oauth_data = json_decode($_SESSION['vk_data'], true);
        $oauth_type = 'vk';
        $name = $oauth_data['name'];
        $email = $oauth_data['email'];
        $oauth_id = $oauth_data['vk_id'];
    } else if (isset($_SESSION['google_data'])) {
        $oauth_data = json_decode($_SESSION['google_data'], true);
        $oauth_type = 'google';
        $name = $oauth_data['name'];
        $email = $oauth_data['email'];
        $oauth_id = $oauth_data['google_id'];
    }

    if (other::length($login) < 4) $error[] = 'small-login';
    if (other::length($login) > 10) $error[] = 'big-login';

    $login_q = $db->query("SELECT * FROM `user` WHERE `login` = '" . $db->filter($login) . "'");
    if ($db->num_rows($login_q) > 0) $error[] = 'login-closed';

    if (other::length($password) < 8) $error[] = 'small-password';
    if (other::length($password) > 32) $error[] = 'big-password';
    if (other::length($name) < 2) $error[] = 'small-name';
    if (other::length($name) > 32) $error[] = 'big-name';
    if (!preg_match("@^([a-zа-я0-9\-]+)$@sui", $login)) $error[] = 'wrong-login';
    if (preg_match("@^([0-9]+)$@sui", $login[0])) $error[] = 'wrong-login';
    if (preg_match("@([\-]{2,20})@sui", $login)) $error[] = 'wrong-login';
    if (preg_match("@([а-я]+)@sui", $login) && preg_match("@([a-z]+)@sui", $login)) $error[] = 'wrong-login';
    if (!preg_match("@^([a-z0-9\.\-\_]{1,20})\@([a-z0-9\-]{1,20})\.([a-z]{1,20})$@sui", $email)) $error[] = 'wrong-email';
    if ($_SESSION['captcha'] != mb_strtoupper($captcha, 'UTF-8')) $error[] = 'wrong-captcha';


    if (count($error) > 0) {
        $_SESSION['captcha'] = md5(time() . mt_rand(17, 49) . md5(mt_rand(0, 494949)));
        die('{"error": 1, "desc": "' . $error[0] . '"}');
    } else {
        $password = other::hash($password);
        $name = $db->filter($name);
        $email = $db->filter($email);
        $date = time();
        $session = other::generateSession();
        $_SESSION['session'] = $session;
        $db->query("INSERT INTO `user` (`login`, `password`, `email`, `name`, `reg_date`, `session`, `group`, `{$oauth_type}_id`)
                            values
                            ('$login', '$password', '$email', '$name', '$date', '$session', '1', '$oauth_id')");
        setcookie('session', $session, time() + 3600 * 60 * 60, '/');
        die('{"success": 1, "session": "' . $session . '"}');
    }