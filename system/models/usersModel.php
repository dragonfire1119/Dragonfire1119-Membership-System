<?php
if (!defined("DMS")) {
	die("You can't access this");
}

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
 *
 */
class usersModel extends mainModel {

	function __construct() {

	}

	public function dologin($email, $password) {
		global $mainModel;

		$this -> connect();

		//call safestrip function
		$santized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = $password;

		//convert password to md5
		$md5password = md5($password);

		// check if the user id and password combination exist in database
		$sql = R::getAll("SELECT * FROM users WHERE email = '$santized_email' AND password = '$md5password'");

		//if match is equal to 1 there is a match
		if (!$sql || (count($sql) < 1)) {

			header('Location: ?error_login');

			// login failed save error to a session
			//$_SESSION['error'] = 'Sorry, wrong username or password';

		} else {

			//call safestrip function
			$santized_email = filter_var($email, FILTER_SANITIZE_EMAIL);

			// check if the user is active or not
			$sql = R::getAll("SELECT * FROM users WHERE email = '$santized_email' AND email_activated = '0'");

			//if match is equal to 1 there is a match
			if (!$sql || (count($sql) < 1)) {
				
				//set session
				$_SESSION['authorized'] = true;

				// reload the page
				$_SESSION['success'] = 'Login Successful';

				/**
				 * This is the cool part: the user has requested that we remember that
				 * he's logged in, so we set two cookies. One to hold his username,
				 * and one to hold his random value userid. It expires by the time
				 * specified in constants.php. Now, next time he comes to our site, we will
				 * log him in automatically, but only if he didn't log out before he left.
				 */
				if ($subremember) {
					setcookie("cookname", $this -> username, time() + COOKIE_EXPIRE, COOKIE_PATH);
					setcookie("cookid", $this -> userid, time() + COOKIE_EXPIRE, COOKIE_PATH);
				}

				header('Location: ?success_login=1');
				exit ;

			}

			header('Location: ?success_login=0');
			exit ;

		}
	}

	public function doregister($email, $username, $password, $passconfirm, $gravatar, $dob) {
		global $session;
		$this -> connect;

		if (empty($_POST['email']) && empty($_POST['username']) && empty($_POST['password']) && empty($_POST['passconfirm']) && empty($_POST['dob'])) {

			header("Location: " . $session -> referrer);
			exit ;
		}

		$md5 = md5($password);

		// check if the user id and password combination exist in database
		$sqlemail = R::getAll("SELECT * FROM users WHERE email = '$email'");

		$sqlusername = R::getAll("SELECT * FROM users WHERE username = '$md5'");

		if (!$sqlemail || (count($sqlemail) < 1)) {

			header("Location: ?error_register=1");
			exit ;
		} else if (!$sqlusername || (count($sqlusername) < 1)) {

			header("Location: ?error_register=2");
			exit ;
		} else if ($password != $passconfirm) {

			header("Location: ?error_register=3");
			exit ;
		} else {

			$time = time();

			$users = R::dispense("users");

			$users -> email = $email;
			$users -> username = $username;
			$users -> password = $password;
			$users -> gravatar = $gravatar;
			$users -> birthday = $dob;
			$users -> userid = "0";
			$users -> userlevel = "1";
			$users -> email = $email;
			$users -> email_activated = "0";
			$users -> timestamp = $time;
			$users -> profile_status = "no";
			$users -> online = "no";
			$users -> bio = "";

			$id = R::store($users);

			header("Location: " . $session -> referrer);
			exit ;
		}
	}

	/**
	 * getUserInfo - Returns the result array from a mysql
	 * query asking for all information stored regarding
	 * the given username. If query fails, NULL is returned.
	 */
	function getUserInfo($username) {
		$this -> connect;
		$sql = R::getAll("SELECT * FROM users WHERE username = '$username'");

		/* Error occurred, return given name by default */
		if (!$sql || (count($sql) < 1)) {
			return NULL;
		}

		return $sql;
	}

	public function updateonlinestatus() {

		if (isset($_SESSION['authorized']) AND isset($_SESSION['success'])) {
			R::exec('update users set online="1" where id=' . $_SESSION['id'] . '');
		} else {
			R::exec('update users set online="0" where id=' . $_SESSION['id'] . '');
		}
	}

}

$users = new usersModel;
?>