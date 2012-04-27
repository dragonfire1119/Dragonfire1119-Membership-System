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
 
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 *
 */
class loginController extends Dms {

	function __construct() {

	}

	public function load() {

		global $users, $dms, $session;

		if (isset($_POST['sublogin'])) {
			$users -> dologin($_POST['email'], $_POST['password']);
		}
		
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
.warning {
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/warning.png');
}
.error {
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/error.png');
}
</style>
";

if (isset($_GET['error_login'])) {
	echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
			<ul>
			<li>
			Wrong Email or Password please try again
			</li>
			</ul></div>";
} else if (isset($_GET['success_login']) AND $_GET['success_login'] == 0) {
	echo "<div class='warning'>
			<ul>
			You must activate your account. Before you can login <a href='?resend'>Resend</a>
			</ul></div>";
} else if (isset($_GET['success_login']) AND $_GET['success_login'] == 1) {
	echo "<div class='success'>
			<ul>
			You have successfully logged in.
			</ul></div>";
} else if (isset($_GET['resend'])) {
	// Create the message
$message = Swift_Message::newInstance()

  // Give the message a subject
  ->setSubject('Your subject')

  // Set the From address with an associative array
  ->setFrom(array('john@doe.com' => 'John Doe'))

  // Set the To addresses with an associative array
  ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))

  // Give it a body
  ->setBody('Here is the message itself')

  // And optionally an alternative body
  ->addPart('<q>Here is the message itself</q>', 'text/html')

  // Optionally add any attachments
  ->attach(Swift_Attachment::fromPath('my-document.pdf'))
  ;
  
  echo "<div class='info'>
			<ul>
			<li>
			</li>
			</ul></div>";
}

		if ($session -> checkifloggedin()) {
			header("Location: ");
			echo "Your already logged in.";
			exit;
		} else {
			$this -> load_view("login");
			exit;
		}
	}

}

$login = new loginController;







