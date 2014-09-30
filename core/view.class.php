<?php
    class view {
        protected $dir; //templates directory
        protected $lang; //language
        protected $authorized;

        protected function getCache($template) {
            return false; //for developing
            if (!isset($_SESSION['cache_' . $template])) return false;
            return $_SESSION['cache_' . $template];
        }

        protected function addCache($template, $content) {
            $_SESSION['cache_' . $template] = $content;
        }

        public function __construct($dir, localization $lang, $user) {
            $this->dir = $dir; //initializing directory
            $this->authorized = (bool) $user->authorized;
            $this->lang = $lang;
        }

        public function invoke($template, $params = [], $return = false) { //can be called w/o params
            $filename = ROOT . '/' . $this->dir . '/tpl/' . ($this->authorized ? '' : 'un') . 'authorized/' . $template . '.html';
            if (!$this->authorized && !file_exists(ROOT . '/' . $this->dir . '/tpl/unauthorized/' . $template . '.html')) $filename = ROOT . '/' . $this->dir . '/tpl/authorized/' . $template . '.html';
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
            $content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
            $content = str_ireplace('{{URI}}', urlencode(other::filter($_SERVER['REQUEST_URI'])), $content); //replacing DIR param
            $content = str_ireplace('{{HTTP_HOST}}', $_SERVER['HTTP_HOST'], $content); //replacing DIR param
            if (!$return) echo $content;
            return $content;
        }
    }
?>