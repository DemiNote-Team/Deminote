<?php
    include '../../core/core.php';

    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $ch = curl_init('https://accounts.google.com/o/oauth2/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => 'Osmium Authorizing',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'code=' . $code . '&client_id=' . $config['google_app_id'] . '&client_secret=' . $config['google_app_secret'] . '&redirect_uri=http://' . $_SERVER['HTTP_HOST'] . '/oauth/google&grant_type=authorization_code',
            CURLOPT_HTTPHEADER => [
                'Content-type: application/x-www-form-urlencoded'
            ]
        ]);
        $e = curl_exec($ch);
        $data = json_decode($e, true);
        if (isset($data['error'])) {
            header('Location: /#unknownerror');
            die();
        } else {
            $token = $data['access_token'];
            $ch = curl_init('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_USERAGENT => 'Osmium Authorizing'
            ]);
            $e = curl_exec($ch);
            $data = json_decode($e, true);
            if (!isset($data['email'])) {
                header('Location: /#error_nomail');
                die();
            } else {
                $name = $data['given_name'];
                $user_id = $data['id'];
                $email = $data['email'];

                $user_q = $db->query("SELECT * FROM `user` WHERE `google_id` = '" . $db->filter($user_id) . "'");
                if ($db->num_rows($user_q) > 0) {
                    $user = $db->fetch($user_q);
                    $session = other::generateSession();
                    $_SESSION['session'] = $session;
                    $db->query("UPDATE `user` SET `session` = '$session' WHERE `id` = '$user[id]'");
                    setcookie('session', $session, time() + 3600 * 60 * 60, '/');
                    header('Location: /');
                    die();
                }

                $user = [
                    "name" => $name,
                    "email" => $email,
                    "google_id" => $user_id
                ];
                $_SESSION['google_data'] = json_encode($user);
                header('Location: /#continuereg');
                die();
            }
        }
    } else {
        header("Location: /#nocode");
        die();
    }