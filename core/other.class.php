<?php

    class other {

        public static function length($string) {
            return mb_strlen($string, 'UTF-8');
        }

        public static function hash($password) {
            return md5($password . md5($password . file_get_contents(ROOT . '/core/solt.dat')));
        }

        public static function filter($string) {
            return htmlspecialchars($string);
        }

        public static function generateSession() {
            return md5(mt_rand(0, 49) . time() . mt_rand(49, 4949));
        }

    }