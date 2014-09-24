<?php
	class View {
		protected $dir; //templates directory

		public function __construct($dir) {
			$this->dir = $dir; //initializing directory
		}

		public function invoke($template, $params = []) { //can be called w/o params
			$filename = ROOT . '/' . $this->dir . '/' . $template . '.php';
			$f = fopen($filename, 'a+');
			$content = fread($f, filesize($filename)); //reading template
			foreach ($params as $key => $value) $content = str_ireplace('{{' . $key . '}}', $value, $content); //replacing params
			$content = str_ireplace('{{DIR}}', '/' . $this->dir, $content); //replacing DIR param
			echo $content;
		}
	}
?>