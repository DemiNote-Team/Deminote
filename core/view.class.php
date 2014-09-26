<?php
	class View {
		protected $dir; //templates directory
        protected $lang; //language
        protected $authorized;

		public function __construct($dir, $lang, $user) {
			$this->dir = $dir; //initializing directory
            $this->authorized = (bool) $user->authorized;
            $this->lang = $lang;
            if (!file_exists(ROOT . '/' . $this->dir . '/localization/' . $lang . '.ini'))
                $this->lang = 'ru'; //default language
		}

		public function invoke($template, $params = []) { //can be called w/o params
            $filename = ROOT . '/' . $this->dir . '/tpl/' . ($this->authorized ? '' : 'un') . 'authorized/' . $template . '.html';
            if (!$this->authorized && !file_exists(ROOT . '/' . $this->dir . '/tpl/unauthorized/' . $template . '.html')) $filename = ROOT . '/' . $this->dir . '/tpl/authorized/' . $template . '.html';
            $lang = parse_ini_file(ROOT . '/' . $this->dir . '/localization/' . $this->lang . '.ini');
			$f = fopen($filename, 'a+');
			$content = fread($f, filesize($filename)); //reading template
            foreach ($params as $key => $value) {
                $content = str_ireplace('{{' . $key . '}}', $value, $content);
            } //replacing params
            preg_match_all("@\{\{:([a-z0-9\_]+?)}\}@sui", $content, $localization);
            $localization = $localization[1];
            foreach ($localization as $value) {
                $content = str_ireplace('{{:' . $value . '}}', $lang[$value], $content);
            } //applying localization
			$content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
			echo $content;
		}
	}
?>