<?php

    class content {

        public function get($module, $params = []) {
            global $view, $db, $user, $config;
            foreach ($params as $key => $value) {
                $$key = $value;
            }
            require ROOT . '/modules/' . $module . '.php';
        }

    }