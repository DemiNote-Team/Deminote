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

    }