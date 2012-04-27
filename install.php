<?php

/**************************************************************************
 * Dragonfire1119 Membership System AKA DMS
 * Copyright (C) 2012  Christopher Hicks
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 **************************************************************************/
 
/**
 * Tell the system that this is DMS reading the pages instead of somebody in the browser
 */
define("DMS", 1);

/**
 * Change the password to your own if you chose to keep install.php
 */
define("password", "dmsinstall");
/**
 * WARNING: Do not change anything below this
 */

session_start();

require_once ("system/config/DMS_Config.php");
require_once ("system/libs/PFBC/Form.php");
require_once ("system/includes/dms.php");

echo "
<style type=\"text/css\">
.info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
}
.info {
    color: #00529B;
    background-color: #BDE5F8;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/info.png');
}
.success {
    color: #4F8A10;
    background-color: #DFF2BF;
    background-image:url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/success.png');
}
.error {
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/error.png');
}
</style>
";

if (!isset($_SESSION['installloggedin'])) {

	if (isset($_POST["form"])) {
		if (empty($_POST['password'])) {
			header("Location: ?error=1");
		} else if ($_POST['password'] != password) {
			header("Location: ?error=2");
		} else {
			$_SESSION['installloggedin'] = "1";
			//setcookie("installloggedin", "installer", time() + COOKIE_EXPIRE, COOKIE_PATH);
			header("Location: " . $_SERVER["PHP_SELF"]);
		}
		exit();
	}

	if (isset($_GET['error']) && $_GET['error'] == 1) {
		echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
					<ul>
					<li>
					Password cannot be empty please try again
					</li>
					</ul></div>";
	} else if (isset($_GET['error']) && $_GET['error'] == 2) {
		echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
					<ul>
					<li>
					Wrong Password please try again
					</li>
					</ul></div>";
	} else if (password == "dmsinstall") {
		echo '<div class="info">
					<ul>
					<li>
					Hello welcome to dmsinstall I sense your new here login with "' . password . '"
					</li>
					</ul></div>';
	}

	$form = new Form("validation", 400);
	$form -> addElement(new Element_Hidden("form", "validation"));
	$form -> addElement(new Element_Password("Password:", "password", array("validation" => new Validation_Required)));
	$form -> addElement(new Element_Button);
	$form -> render();
} else if (isset($_SESSION['installloggedin']) && $_SESSION['installloggedin'] == 1) {
	if (isset($_GET['logout'])) {
		session_destroy();
		header("Location: " . $_SERVER["PHP_SELF"]);
	} else if (isset($_POST['form'])) {
		if (empty($_POST['host']) && empty($_POST['username']) && empty($_POST['name']) && empty($_POST['type'])) {
			echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
					<ul>
					<li>
					Nothing can be empty please try again accept the password
					</li>
					</ul></div>";
		} else if (isset($_GET['delete']) && $_GET['delete'] == "install.php") {
			echo "<div class='success'>
					<ul>
					<li>
					You have successfully deleted install.php
					</li>
					</ul></div>";
			$my_file = 'install.php';
			unlink($my_file);
		} else {
			echo "<div class='success'>
					<ul>
					<li>
					You have successfully setup DMS you can always come back here and change it at anytime remember if you keep install.php go in it and change the password up top.
					<a hreff='?delete=install.php'>Delete install.php</a> or keep it.
					</li>
					</ul></div>";

			$my_file = 'system/config/db_config.php';
			//fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
			$handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
			$data = '
<?php
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVER", "' . $_POST['host'] . '");
define("DB_USER", "' . $_POST['username'] . '");
define("DB_PASS", "' . $_POST['password'] . '");
define("DB_NAME", "' . $_POST['name'] . '");
define("DB_PORT", "' . $_POST['port'] . '");
define("DB_TYPE", "' . $_POST['type'] . '");';
			fwrite($handle, $data);
		}
	}

	if (isset($_GET['delete']) && $_GET['delete'] == 1) {
		echo "<div class='success'>
					<ul>
					<li>
					You have successfully deleted install.php <a href='index.php'>Go to DMS</a>
					</li>
					</ul></div>";
		$my_file = 'install.php';
		unlink($my_file);
		exit ;
	}
	$options = array("mysql", "postgresql", "sqlite", "cubrid");
	$form = new Form("validation", 400);
	$form -> addElement(new Element_Hidden("form", "validation"));
	$form -> addElement(new Element_Textbox("Database Host:", "host", array(
	"validation" => new Validation_Required,
	"description" => "This is normally localhost or 127.0.0.1"
)));
	$form -> addElement(new Element_Textbox("Database Username:", "username", array(
	"validation" => new Validation_Required,
	"description" => "This is normally root if your using your localhost"
)));
	$form -> addElement(new Element_Textbox("Database Password:", "password"));
	$form -> addElement(new Element_Textbox("Database Name:", "name", array(
	"validation" => new Validation_Required
)));
	$form -> addElement(new Element_Textbox("Database Port:", "port"));
	$form -> addElement(new Element_Select("Database Type:", "type", $options , array(
	"validation" => new Validation_Required,
	"description" => "Pick one of these"
)));
	$form -> addElement(new Element_Button);
	$form -> render();
}
