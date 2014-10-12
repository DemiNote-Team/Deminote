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
            $this->dir = $dir; //initializing directory
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
                $content = fread($f, (filesize($filename) > 0 ? filesize($filename) : 1)); //reading template
                $this->addCache($template, $content);
            }
            foreach ($params as $key => $value) {
                $content = str_ireplace('{{' . $key . '}}', $value, $content);
            } //replacing params
            preg_match_all("@\{\{:([a-z0-9\_]+?)}\}@sui", $content, $localization);
            $localization = $localization[1];
            foreach ($localization as $value) {
                $content = str_ireplace('{{:' . $value . '}}', $lang[$value], $content);
            } //applying lang
            foreach ($quests as $key => $value) {
                $content = preg_replace("@\{\?$key=((?!$value).+?)\?\}(.+?)\{\?\?\}@sui", "", $content);
                $content = preg_replace("@\{\?$key=$value\?\}(.+?)\{\?\?\}@sui", "$1", $content);
            }

            preg_match_all("@\{\?access=(.+?)\?\}(.+?)\{\?\?\}@sui", $content, $perms);
            foreach ($perms[1] as $value) {
                if ($this->user->canAccess($value))
                    $content = preg_replace("@\{\?access=$value\?\}(.+?)\{\?\?\}@sui", "$1", $content);
            }

            $content = preg_replace("@\{\?authorized=((?!" . (int) $this->authorized . ").+?)\?\}(.+?)\{\?\?\}@sui", "", $content);
            $content = preg_replace("@\{\?authorized=" . (int) $this->authorized . "\?\}(.+?)\{\?\?\}@sui", "$1", $content);
            $content = preg_replace("@\{\?(.+?)\?\}(.+?)\{\?\?\}@sui", "", $content);

            $content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
            $content = str_ireplace('{{URI}}', urlencode(other::filter($_SERVER['REQUEST_URI'])), $content); //replacing URI param
            $content = str_ireplace('{{HTTP_HOST}}', $_SERVER['HTTP_HOST'], $content); //replacing DIR param
            $content = preg_replace("@\{\?((.+?)|(.+?){0})\?\}@sui", "", $content);
            if (!$return) echo $content;
            return $content;
        }
    }
?>