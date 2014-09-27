<?php
    $view->invoke('content-close');
    $view->invoke('right', ['login' => ($user->authorized ? $user->data['login'] : 'undefined')]);
    $view->invoke('foot');