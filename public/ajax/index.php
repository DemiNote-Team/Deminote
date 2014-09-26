<?php
    include '../../core/core.php';
    if (!isset($_POST['method'])) die('{"error": 1, "desc": "no-method"}');

    switch ($_POST['method']) {
        case 'register':
            $login = $_POST['login'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['captcha'];
            $captcha = $_POST['captcha'];
            $error = [];

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
            if ($_SESSION['captcha'] != mb_strtoupper($captcha, 'UTF-8')) $error[] = 'wrong-captcha' . $_SESSION['captcha'];


            if (count($error) > 0) {
                $_SESSION['captcha'] = md5(time() . mt_rand(17, 49) . md5(mt_rand(0, 494949)));
                die('{"error": 1, "desc": "' . $error[0] . '"}');
            } else {
                $password = other::hash($password);
                $name = $db->filter($name);
                $email = $db->filter($email);
                $date = time();
                $session = md5(mt_rand(0, 49) . time() . mt_rand(49, 4949));
                $_SESSION['session'] = $session;
                $db->query("INSERT INTO `user` (`login`, `password`, `email`, `name`, `reg_date`, `session`, `group`)
                            values
                            ('$login', '$password', '$email', '$name', '$date', '$session', '1')");

                die('{"success": 1, "session": "' . $session . '"}');
            }
            break;
        case 'login':

            break;
        default:
            die('{"error": 1, "desc": "wrong-method"}');
    }