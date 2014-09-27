<?php
    include '../../core/core.php';

    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $ch = curl_init('https://oauth.vk.com/access_token?client_id=' . $config['vk_app_id'] . '&client_secret=' . $config['vk_app_secret'] . '&code=' . $code . '&redirect_uri=http://' . $_SERVER['HTTP_HOST'] . '/oauth/vk/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => 'Osmium Authorizing'
        ]);
        $e = curl_exec($ch);
        $data = json_decode($e, true);
        if (isset($data['error'])) {
            header('Location: /#unknownerror');
            die();
        } else {
            if (!isset($data['email'])) {
                header('Location: /#error_nomail');
                die();
            } else {
                $token = $data['access_token'];
                $user_id = $data['user_id'];
                $email = $data['email'];

                $user_q = $db->query("SELECT * FROM `user` WHERE `vk_id` = '" . $db->filter($user_id) . "'");
                if ($db->num_rows($user_q) > 0) {
                    $user = $db->fetch($user_q);
                    $session = other::generateSession();
                    $_SESSION['session'] = $session;
                    $db->query("UPDATE `user` SET `session` = '$session' WHERE `id` = '$user[id]'");
                    setcookie('session', $session, time() + 3600 * 60 * 60, '/');
                    header('Location: /');
                    die();
                }

                $ch = curl_init('https://api.vk.com/method/users.get?user_ids=' . $user_id . '&access_token=' . $token);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_USERAGENT => 'Osmium Authorizing'
                ]);
                $e = curl_exec($ch);
                $e = json_decode($e, true);
                if (isset($e['error'])) {
                    header('Location: /#unknown_error');
                    die();
                } else {
                    $data = $e['response'][0];
                    $name = $data['first_name'];

                    $user = [
                        "name" => $name,
                        "email" => $email,
                        "vk_id" => $user_id
                    ];
                    $_SESSION['vk_data'] = json_encode($user);
                    header('Location: /#continuereg');
                    die();
                }
            }
        }
    } else {
        header("Location: /#nocode");
        die();
    }