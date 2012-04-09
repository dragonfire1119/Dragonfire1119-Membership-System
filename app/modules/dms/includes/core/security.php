<?php

/* Dragonfire1119 Membership Script Beta 0.2
 * Copyright (c) 2011 Christopher Hicks
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: December 13, 2011
 * ------------------------------------------------------------------------------------------------ */

if (!defined('DMS_SECURITY')) {
	die('Hacking attempt...');
}

class Security {

	var $security;
	var $defineit;
	var $idefined;
	var $appredirect;
	var $host;
	var $db;
	var $user;
	var $pass;
	var $db_type;

	/* Class constructor */

	function Security() {
		/* Make connection to database */
		$this -> host = DB_SERVER;
		$this -> db = DB_NAME;
		$this -> user = DB_USER;
		$this -> pass = DB_PASSS;
		$this -> db_type = DB_TYPE;
	}

	function defineit() {
		define('DMS_SECURITY', 1);
	}

	function idefined() {
		if (!defined('DMS_SECURITY')) {
			die('Hacking attempt...');
		}
	}

	function appredirect() {
		global $session;

		if (!$session -> isAdmin()) {
			header("Location: ../index.php");
		} else {
			header("Location: admin/index.php");
		}
	}

	function notactivated() {
		global $database, $session;
		$this -> host;
		$this -> db;
		$this -> user;
		$this -> pass;
		$this -> db_type;
		try {
			$dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "", DB_USER, DB_PASSS);
		} catch (PDOException $e) {
			echo $e -> getMessage();
		}
		echo "Check your email to activate your account!";

		if (isset($_POST['resend'])) {
			$sth = $dbh -> prepare("SELECT * FROM " . TBL_USERS . " WHERE username = '$session->username'");
			$sth -> execute();
			/* Return result array */
			$r = $sth -> fetchall();

			$from = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">";
			$email = $r['email'];
			$subject = mailer_suject;
			$body = $session -> username . ",\n\n" . mailer_welcome . "Hi $session->username," . "Complete this step to activate your login identity at " . dyn_www . "" . "Click the line below to activate when ready " . "http://" . dyn_www . "/activation.php?user=$session->username" . " If the URL above is not an active link, please copy and paste it into your browser address bar " . "Login after successful activation using your: " . "See you on the site!" . mailer_name;

			mail($email, $subject, $body, $from);
		}

		echo '<form method="post" action="index.php?go=notactivated">
    <input type="submit" value="resend email" name="resend"></input> - <a href="process.php">Logout</a>
</form>';

		echo "<br />";
		echo "<br />";
		echo POWERED_BY;
	}

	function checkifactivated() {
		global $session, $database;
		$this -> host;
		$this -> db;
		$this -> user;
		$this -> pass;
		$this -> db_type;
		try {
			$dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . "", DB_USER, DB_PASSS);
		} catch (PDOException $e) {
			echo $e -> getMessage();
		}
		$sql = "SELECT email_activated FROM " . TBL_USERS . " WHERE username = '$session->username'";
		$stmt = $dbh -> query($sql);
		if (is_array($stmt)) {
			foreach ($stmt as $row) {
				if ($row['email_activated'] == "0") {
					$this -> notactivated();
					exit ;
				}
			}
		}
	}

}

/**
 * Initialize object
 */
$security = new Security;
?>