<?php
	class View {
		protected $dir; //templates directory
        protected $authorized;

		public function __construct($dir, $user) {
			$this->dir = $dir; //initializing directory
            $this->authorized = (bool) $user->authorized;
		}

		public function invoke($template, $params = []) { //can be called w/o params
            $filename = ROOT . '/' . $this->dir . '/tpl/' . ($this->authorized ? '' : 'un') . 'authorized/' . $template . '.html';
            if (!$this->authorized && !file_exists(ROOT . '/' . $this->dir . '/tpl/unauthorized/' . $template . '.html')) $filename = ROOT . '/' . $this->dir . '/tpl/authorized/' . $template . '.html';
			$f = fopen($filename, 'a+');
			$content = fread($f, filesize($filename)); //reading template
			foreach ($params as $key => $value) $content = str_ireplace('{{' . $key . '}}', $value, $content); //replacing params
			$content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
			echo $content;
		}
	}
?>