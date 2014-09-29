<?php

    class router {
        public $module;
        public  $params;

        public function __construct() {
            $path = explode('/', $_SERVER['REQUEST_URI']);
            $this->module = (empty($path[1]) ? 'index' : $path[1]);
            unset($path[0], $path[1]);
            $this->params = other::rekeyArray($path);
        }

        public function route($link = null) {
            if ($link) {
                $path = explode('/', $link);
                $this->module = (empty($path[1]) ? 'index' : $path[1]);
                unset($path[0], $path[1]);
                $this->params = other::rekeyArray($path);
            }
            content::get($this->module, $this->params);
        }
    }