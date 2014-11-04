<?php
    class view {
        protected $dir; //templates directory
        protected $lang; //language
        protected $authorized;
        protected $user;
        public $executeTime;

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
            $startTime = microtime(true);

            $filename = ROOT . '/' . $this->dir . '/tpl/' . $template . '.tpl';
            $lang = $this->lang->getData();
            $content = $this->getCache($template);
            if (!$content) {
                $f = fopen($filename, 'a+');
                $content = fread($f, (filesize($filename) > 0 ? filesize($filename) : 1));
                $this->addCache($template, $content);
            }

            $params['dir'] = '/' . $this->dir;
            $params['uri'] = urlencode(other::filter($_SERVER['REQUEST_URI']));
            $params['http_host'] = $_SERVER['HTTP_HOST'];
            foreach ($params as $key => $value) {
                $content = str_ireplace('{{' . $key . '}}', $value, $content);
            } //applying params

            preg_match_all("@{{:([a-z0-9_]+?)}}@sui", $content, $localization);
            $localization = $localization[1];
            foreach ($localization as $value) {
                $content = str_ireplace('{{:' . $value . '}}', $lang[$value], $content);
            } //applying lang

            $quests['authorized'] = (int) $this->authorized;
            preg_match_all("@{\?([a-z0-9_\-]+?)=([a-z0-9_\-]+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
            while (!empty($matches[0])) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    if ($matches[1][$i] == 'access') {
                        $content = preg_replace("@{\?access=" . $matches[2][$i] . "\?}(((?!{\?.+\?}).)*?){\?\?}@sui", ($this->user->canAccess($matches[2][$i]) ? "$1" : ""), $content);
                        continue;
                    }
                    $content = preg_replace("@{\?" . $matches[1][$i] . "=" . (string) @$quests[$matches[1][$i]] . "\?}(((?!{\?.+\?}).)*?){\?\?}@sui", "$1", $content);
                    $content = preg_replace("@{\?" . $matches[1][$i] . "=(.+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", "", $content);
                }
                preg_match_all("@{\?([a-z0-9_\-]+?)=([a-z0-9_\-]+?)\?}(((?!{\?.+\?}).)*?){\?\?}@sui", $content, $matches);
            }

            if (!$return) echo $content;
            $this->executeTime += (microtime(true) - $startTime);
            return $content;
        }
    }
?>