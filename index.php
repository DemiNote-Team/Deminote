<?php
	include 'core/core.php';

	$view->invoke("head");
	$view->invoke("sidebar", ["title" => "Osmium CMS"]);
	$view->invoke("content-open");

	/////////////////////////////////
	$view->invoke("blog", [
		"title" => "История Игната #1",
		"date" => "22:31, 24/09/2014",
	    "blog" => 'Все о Игнате',
		"text" => "Lorem ipsum Ignat sit amet.",
        "id" => 1,
        "name" => "istoriya_ignata_1"
	]);
 	$view->invoke("blog", [
	    "title" => "Lorem Ipsum",
	    "date" => "22:31, 24/09/2014",
	    "blog" => 'lorem',
	    "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        "id" => 2,
        "name" => "lorem_ipsum"
    ]);
 	/////////////////////////////////

	$view->invoke("content-close");
	$view->invoke("right");
	$view->invoke("foot");