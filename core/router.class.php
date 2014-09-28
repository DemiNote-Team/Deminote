<?php

    class router {
        public $module;
        protected $params;
        protected $content;

        public function __construct(content $content) {
            $this->content = $content;
            $path = explode('/', $_SERVER['REQUEST_URI']);
            $this->module = (empty($path[1]) ? 'index' : $path[1]);
            unset($path[0], $path[1]);
            $this->params = other::rekeyArray($path);
        }

        public function route() {
            $this->content->get($this->module, $this->params);
        }
    }