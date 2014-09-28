<?php

    class other {

        public static function length($string) {
            return mb_strlen($string, 'UTF-8');
        }

        public static function hash($password) {
            return md5($password . md5($password . file_get_contents(ROOT . '/core/solt.dat')));
        }

        public static function filter($string) {
            return htmlspecialchars($string, ENT_QUOTES);
        }

        public static function generateSession() {
            return md5(mt_rand(0, 49) . time() . mt_rand(49, 4949));
        }

        public static function checkAjax() {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        }

        public static function rekeyArray($array) {
            if (!is_array($array)) return false;
            $new_array = [];
            foreach ($array as $value) {
                $new_array[] = $value;
            }
            return $new_array;
        }

        public static function formatTime($time) {
            return "41 минуту назад";
        }

    }