<?php
	include 'core/core.php';

	$view->invoke("head");
	$view->invoke("sidebar", ["title" => "Osmium CMS"]);
	$view->invoke("content-open");

	/////////////////////////////////
	$view->invoke("blog", [
		"title" => "Lorem Ipsum",
		"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
	]);
	$view->invoke("blog", [
		"title" => "Lorem Ipsum",
		"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
	]);
	/////////////////////////////////

	$view->invoke("content-close");
	$view->invoke("right");
	$view->invoke("foot");