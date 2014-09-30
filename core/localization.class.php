<?php

    class localization {
        protected $lang;
        protected $data;

        public function __construct($template, $lang, $default) {
            $this->lang = $lang;
            if (!file_exists(ROOT . '/' . $template . '/lang/' . $this->lang . '.ini')) {
                $filename = ROOT . '/' . $template . '/lang/' . $default . '.ini';
            } else $filename = ROOT . '/' . $template . '/lang/' . $this->lang . '.ini';
            $this->data = parse_ini_file($filename);
        }

        public function getData() {
            return $this->data;
        }
    }