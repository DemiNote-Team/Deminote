<?php

    class content {

        public function get($module, $arg = []) {
            global $view, $db, $user, $config;
            if (file_exists(ROOT . '/modules/' . $module . '.php'))
                require ROOT . '/modules/' . $module . '.php';
            else echo "&nbsp;<!-- NO MODULE -->&nbsp;";
        }

    }