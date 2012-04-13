Dragonfire1119 Membership System
=================================

I created this to be really simple and dynamic

For anybody's Eyes Only
=========================
DMS was created for anybody that knows how to copy/paste.


The Benefits
============
* A easy to use system that you don't have to learn
* Takes only 3 lines of code to get a login or register page
* No install just edit the app/config.php and your done
* An object oriented approach which makes modifications easy.


Installation
============
Theres just one step to install DMS edit app/config.php

Online 25 to 35

		/**
		* Database Constants - these constants are required
		* in order for there to be a successful connection
		* to the MySQL database. Make sure the information is
		* correct.
		*/
		define("DB_SERVER", "localhost");
		define("DB_USER", "root");
		define("DB_PASSS", "");
		define("DB_NAME", "dms");
		define("DB_TYPE", "mysql");


Login Page
=========
This is just 4 lines of code to get a full login page

		define("DMS_SECURITY", 1);
		include ("app/core.php");
		$checks -> render("checklogin", "login");
		$pm -> render("messagesender", $session -> username);
		
Register Page
================
This is just 3 lines of code to get a full register page

        define("DMS_SECURITY", 1);
		include ("app/core.php");
		$register -> render();

html in php
==========
html in php:

		define("DMS_SECURITY", 1);
		include ("app/core.php");
		echo $html -> doctype;
		echo $html -> html;
		echo $html -> head;
		$html -> title("Login");
		echo $html -> endhead;
		echo $html -> body;
		Your render code in here
		echo $html -> endbody;
		echo $html -> endhtml;

