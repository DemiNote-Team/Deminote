<?php

    class other {

        public static function length($string) {
            return mb_strlen($string, 'UTF-8');
        }

        public static function hash($password) {
            return md5($password . md5($password . file_get_contents(ROOT . '/core/solt.dat')));
        }

        public static function filter($string, $quotes = 1) {
            return htmlspecialchars($string, ($quotes ? ENT_QUOTES : ENT_NOQUOTES));
        }

        public static function translit($string) {
            $string = preg_replace("@([^a-zа-я0-9\_ ])@sui", "", $string);
            $string = mb_strtolower($string, 'UTF-8');
            $translit = [
                'ый' => 'y',
                'ий' => 'y',
                'ье' => 'ye',
                'ъе' => 'ye',
                'ьё' => 'ye',
                'ъё' => 'ye',
                'ё' => 'yo',
                'ж' => 'zh',
                'ш' => 'sh',
                'щ' => 'shch',
                'ю' => 'yu',
                'я' => 'ya',
                'ы' => 'y',
                'ч' => 'ch',
                'ц' => 'ts',
                'й' => 'y',
                'а' => 'a',
                'б' => 'b',
                'в' => 'v',
                'г' => 'g',
                'д' => 'd',
                'е' => 'e',
                'з' => 'z',
                'и' => 'i',
                'к' => 'k',
                'л' => 'l',
                'м' => 'm',
                'н' => 'n',
                'о' => 'o',
                'п' => 'p',
                'р' => 'r',
                'с' => 's',
                'т' => 't',
                'у' => 'u',
                'ф' => 'f',
                'ъ' => '',
                'ь' => '',
                'э' => 'e',
                ' ' => '_'
            ];
            $string = strtr($string, $translit);
            return $string;
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

        public static function formatTime($time, localization $lang) {
            $now = time();
            $lang = $lang->getData();
            $diff = ($now - $time);
            $return = '';
            if ($diff < 20) {
                $return = $lang['just_now'];
            } else if ($diff < 60) {
                $return = $diff . ' ' . $lang['seconds_ago'];
            } else if ($diff < 3600) {
                $return = max(1, round($diff / 60)) . ' ' . $lang['minutes_ago'];
            } else if ($diff < 3600 * 24) {
                $return = max (1, round($diff / 3600)) . ' ' . $lang['hours_ago'];
            } else if ($diff < 3600 * 24 * 30) {
                $return = max (1, round($diff / 3600 / 24)) . ' ' . $lang['days_ago'];
            } else {
                $return = date("d.m.Y");
            }
            return $return;
        }

        public static function jsonDie($arr) {
            die(json_encode($arr));
        }

        public static function processOutput($text, $nocut = false) {
            if (!$nocut) $text = str_replace('[cut]', '', $text);
            $text = other::filter($text, false);
            $text = nl2br($text);
            $text = str_replace('&amp;', '&', $text);
            $text = str_replace('[br /]', '<br />', $text);
            $text = preg_replace("@\[b\](.+?)\[\/b\]@sui", "<b>$1</b>", $text);
            $text = preg_replace("@\[s\](.+?)\[\/s\]@sui", "<s>$1</s>", $text);
            $text = preg_replace("@\[i\](.+?)\[\/i\]@sui", "<i>$1</i>", $text);
            $text = preg_replace("@\[ul\](.+?)\[\/ul\]@sui", "<ul>$1</ul>", $text);
            $text = preg_replace("@\[ol\](.+?)\[\/ol\]@sui", "<ol>$1</ol>", $text);
            $text = preg_replace("@\[li\](.+?)\[\/li\]@sui", "<li>$1</li>", $text);
            $text = preg_replace("@\[q\](.+?)\[\/q\]@sui", "<blockquote>$1</blockquote>", $text);
            $text = preg_replace("@\[a href=\"http(.+?)\"\](.+?)\[\/a\]@sui", "<a href=\"http$1\">$2</a>", $text);
            $text = preg_replace("@\[img alt=\"\" src=\"http(.+?)\" \/\]@sui", "<img class=\"userimg\" src=\"http$1\" />", $text);
            return $text;
        }

    }