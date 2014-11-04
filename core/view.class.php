<?php
    class view {
        protected $dir; //templates directory
        protected $lang; //language
        protected $authorized;
        protected $user;

        protected function getCache($template) {
            return false; //uncomment for developing
            if (!isset($_SESSION['cache_' . $template])) return false;
            return $_SESSION['cache_' . $template];
        }

        protected function addCache($template, $content) {
            $_SESSION['cache_' . $template] = $content;
        }

        public function __construct($dir, localization $lang, user $user) {
            $this->dir = $dir;
            $this->authorized = (bool) $user->authorized;
            $this->user = $user;
            $this->lang = $lang;
        }

        public function invoke($template, $params = [], $return = false, $quests = []) { //can be called w/o params
            $filename = ROOT . '/' . $this->dir . '/tpl/' . $template . '.tpl';
            $lang = $this->lang->getData();
            $content = $this->getCache($template);
            if (!$content) {
                $f = fopen($filename, 'a+');
                $content = fread($f, (filesize($filename) > 0 ? filesize($filename) : 1));
                $this->addCache($template, $content);
            }
            foreach ($params as $key => $value) {
                $content = str_ireplace('{{' . $key . '}}', $value, $content);
            }
            preg_match_all("@{{:([a-z0-9_]+?)}}@sui", $content, $localization);
            $localization = $localization[1];
            foreach ($localization as $value) {
                $content = str_ireplace('{{:' . $value . '}}', $lang[$value], $content);
            } //applying lang

            foreach ($quests as $key => $value) {
                preg_match_all("@{\?$key=$value\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
                while (!empty($matches[0])) {
                    $content = str_replace($matches[0][0], $matches[1][0], $content);
                    preg_match_all("@{\?$key=$value\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
                }
                preg_match_all("@{\?$key=((?!$value).+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
                while (!empty($matches[0])) {
                    $content = str_replace($matches[0][0], "", $content);
                    preg_match_all("@{\?$key=((?!$value).+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
                }
            }

            preg_match_all("@{\?access=([a-z0-9]+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $perms);
            while (!empty($perms[0])) {
                foreach ($perms[1] as $value) {
                    if ($this->user->canAccess($value))
                        $content = preg_replace("@{\?access=$value\?}(((?!{\?.+\?}).)*?){\?\?}@sui", "$1", $content);
                    else $content = preg_replace("@{\?access=$value\?}(((?!{\?.+\?}).)*?){\?\?}@sui", "", $content);
                }
                preg_match_all("@{\?access=([a-z0-9]+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $perms);
            }

            $content = preg_replace("@{\?authorized=((?!" . (int) $this->authorized . ").+?)\?}(.+?){\?\?}@sui", "", $content);
            $content = preg_replace("@{\?authorized=" . (int) $this->authorized . "\?}(.+?){\?\?}@sui", "$1", $content);
            $content = preg_replace("@{\?(.+?)\?}(.+?){\?\?}@sui", "", $content);

            $content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
            $content = str_ireplace('{{URI}}', urlencode(other::filter($_SERVER['REQUEST_URI'])), $content); //replacing URI param
            $content = str_ireplace('{{HTTP_HOST}}', $_SERVER['HTTP_HOST'], $content); //replacing HTTP_HOST param
            $content = preg_replace("@{\?((.+?)|(.+?){0})\?}@sui", "", $content);
            if (!$return) echo $content;
            return $content;
        }
    }
?>