<?php
    /////////////////////////////////
    $view->invoke('blogs-list-open');
    /////////////////////////////////
    $view->invoke('blog-name', [
        'name' => 'Osmium',
        'id' => '1',
        'translit' => 'Osmium'
    ]);
    $view->invoke('blog-name', [
        'name' => 'Обновления',
        'id' => '2',
        'translit' => 'Obnovleniya'
    ]);
    $view->invoke('blog-name', [
        'name' => 'Вопросы и ответы',
        'id' => '3',
        'translit' => 'Voprosy_i_otvety'
    ]);
    $view->invoke('blog-name', [
        'name' => 'English Support',
        'id' => '4',
        'translit' => 'English_Support'
    ]);
    ////////////////////////////////
    $view->invoke('blogs-list-close');
    /////////////////////////////////
    $view->invoke('page-title', ['title' => '{{:new_topics}} - {{name}}', 'name' => 'Osmium']);
    /////////////////////////////////
    $view->invoke('blog', [
        'title' => 'История Игната #1',
        'date' => '22:31, 24/09/2014',
        'blog' => 'Все о Игнате',
        'text' => 'Lorem ipsum Ignat sit amet.',
        'id' => 1,
        'name' => 'istoriya_ignata_1',
        'login' => 'Efog'
    ]);
    $view->invoke('blog', [
        'title' => 'Lorem Ipsum',
        'date' => '22:31, 24/09/2014',
        'blog' => 'lorem',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'id' => 2,
        'name' => 'lorem_ipsum',
        'login' => 'Ignat'
    ]);
    $view->invoke('blog', [
        'title' => 'Lorem Ipsum #2 - test',
        'date' => '23:31, 24/09/2014',
        'blog' => 'lorem',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'id' => 3,
        'name' => 'lorem_ipsum',
        'login' => 'Bioraq'
    ]);
    $view->invoke('blog', [
        'title' => 'История Игната #1',
        'date' => '22:31, 24/09/2014',
        'blog' => 'Все о Игнате',
        'text' => 'Lorem ipsum Ignat sit amet.',
        'id' => 1,
        'name' => 'istoriya_ignata_1',
        'login' => 'chmod'
    ]);
    $view->invoke('blog', [
        'title' => 'Lorem Ipsum',
        'date' => '22:31, 24/09/2014',
        'blog' => 'lorem',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'id' => 2,
        'name' => 'lorem_ipsum',
        'login' => 'Apache'
    ]);
    $view->invoke('blog', [
        'title' => 'История Игната #1',
        'date' => '22:31, 24/09/2014',
        'blog' => 'Все о Игнате',
        'text' => 'Lorem ipsum Ignat sit amet.',
        'id' => 1,
        'name' => 'istoriya_ignata_1',
        'login' => 'Efog'
    ]);
    $view->invoke('blog', [
        'title' => 'Lorem Ipsum',
        'date' => '22:31, 24/09/2014',
        'blog' => 'lorem',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'id' => 2,
        'name' => 'lorem_ipsum',
        'login' => 'Efog'
    ]);
    /////////////////////////////////