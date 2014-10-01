<?php

    class content {

        public static function get($module, $arg = []) {
            global $view, $db, $user, $config, $lang;
            if (file_exists(ROOT . '/modules/' . $module . '.php'))
                require ROOT . '/modules/' . $module . '.php';
            else {
                $view->invoke('404');
            };
        }

    }