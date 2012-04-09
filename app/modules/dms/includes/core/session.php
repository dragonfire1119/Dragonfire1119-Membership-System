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
 * Date: December 28, 2011
 * ------------------------------------------------------------------------------------------------ */
if (!defined('DMS_SECURITY')) {
	die('Hacking attempt...');
}
ob_start();
class Session {

	var $id;
	var $username;
	//Username given on sign-up
	var $userid;
	//Random value generated on current login
	var $userlevel;
	//The level to which the user pertains
	var $time;
	//Time user was last active (page loaded)
	var $logged_in;
	//True if user is logged in, false otherwise
	var $userinfo = array();
	//The array holding all user info
	var $url;
	//The page url current being viewed
	var $referrer;
	//Last recorded site page viewed

	/**
	 * Note: referrer should really only be considered the actual
	 * page referrer in process.php, any other time it may be
	 * inaccurate.
	 */
	/* Class constructor */

	function __construct() {
		$this -> time = time();
		$this -> startSession();
	}

	/**
	 * startSession - Performs all the actions necessary to
	 * initialize this session object. Tries to determine if the
	 * the user has logged in already, and sets the variables
	 * accordingly. Also takes advantage of this page load to
	 * update the active visitors tables.
	 */
	function startSession() {
		global $database;
		//The database connection
		session_start();
		//Tell PHP to start the session

		/* Determine if user is logged in */
		$this -> logged_in = $this -> checkLogin();

		/**
		 * Set guest value to users not logged in, and update
		 * active guests table accordingly.
		 */
		if (!$this -> logged_in) {
			$this -> id = $_SESSION['id'] = '100000000';
			$this -> username = $_SESSION['username'] = GUEST_NAME;
			$this -> userlevel = GUEST_LEVEL;
			$database -> addActiveGuest($_SERVER['REMOTE_ADDR'], $this -> time);
		}
		/* Update users last active timestamp */
		else {
			$database -> addActiveUser($this -> username, $this -> time);
		}

		/* Remove inactive visitors from database */
		$database -> removeInactiveUsers();
		$database -> removeInactiveGuests();

		/* Set referrer page */
		if (isset($_SESSION['url'])) {
			$this -> referrer = $_SESSION['url'];
		} else {
			$this -> referrer = "/";
		}

		/* Set current url */
		$this -> url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
	}

	/**
	 * checkLogin - Checks if the user has already previously
	 * logged in, and a session with the user has already been
	 * established. Also checks to see if user has been remembered.
	 * If so, the database is queried to make sure of the user's
	 * authenticity. Returns true if the user has logged in.
	 */
	function checkLogin() {
		global $database;
		//The database connection
		/* Check if user has been remembered */
		if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
			$this -> username = $_SESSION['username'] = $_COOKIE['cookname'];
			$this -> userid = $_SESSION['userid'] = $_COOKIE['cookid'];
		}

		/* Username and userid have been set and not guest */
		if (isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != GUEST_NAME) {
			/* Confirm that username and userid are valid */
			if ($database -> confirmUserID($_SESSION['username']) != 0) {
				/* Variables are incorrect, user not logged in */
				unset($_SESSION['username']);
				unset($_SESSION['userid']);
				return false;
			}

			/* User is logged in, set class variables */
			//$this->userinfo = $database->getUserInfo($_SESSION['username']);

			foreach ($database->getUserInfo($_SESSION['username']) as $this->userinfo) {
				$this -> id = $this -> userinfo['id'];
				$this -> username = $this -> userinfo['username'];
				$this -> userid = $this -> userinfo['userid'];
				$this -> userlevel = $this -> userinfo['userlevel'];
			}
			return true;
		}
		/* User not logged in */
		else {
			return false;
		}
	}

	/**
	 * login - The user has submitted his username and password
	 * through the login form, this function checks the authenticity
	 * of that information in the database and creates the session.
	 * Effectively logging in the user if all goes well.
	 */
	function login($subuser, $subpass, $subremember) {
		global $database, $dmsForm;
		//The database and form object

		/* Username error checking */
		$field = "user";
		//Use field name for username
		if (!$subuser || strlen($subuser = trim($subuser)) == 0) {
			$dmsForm -> setError($field, "* Username not entered");
		} else {
			/* Check if username is not alphanumeric */
			// preg_match('^([0-9a-z]*$)/i', $subuser)
			if (!preg_match("/^[a-z0-9]+([\\s]{1}[a-z0-9]|[a-z0-9])+$/i", $subuser)) {
				$dmsForm -> setError($field, "* Username not alphanumeric");
			}
		}

		/* Password error checking */
		$field = "pass";
		//Use field name for password
		if (!$subpass) {
			$dmsForm -> setError($field, "* Password not entered");
		}

		/* Return if form errors exist */
		if ($dmsForm -> num_errors > 0) {
			return false;
		}

		/* Checks that username is in database and password is correct */
		$subuser = stripslashes($subuser);
		$result = $database -> confirmUserPass($subuser, md5($subpass));

		/* Check error codes */
		if ($result == 1) {
			$field = "user";
			$dmsForm -> setError($field, "* Username not found");
		} elseif ($result == 2) {
			$field = "pass";
			$dmsForm -> setError($field, "* Invalid password");
		}

		/* Return if form errors exist */
		if ($dmsForm -> num_errors > 0) {
			return false;
		}
		/* Username and password correct, register session variables */
		//$this->userinfo = $database->getUserInfo($subuser);
		foreach ($database->getUserInfo($subuser) as $this->userinfo) {
			$this -> id = $_SESSION['id'] = $this -> userinfo['id'];
			$this -> username = $_SESSION['username'] = $this -> userinfo['username'];
			$this -> userid = $_SESSION['userid'] = $this -> generateRandID();
			$this -> userlevel = $this -> userinfo['userlevel'];
		}

		/* Insert userid into database and update active users table */
		$database -> updateUserField($this -> username, "userid", $this -> userid);
		$database -> addActiveUser($this -> username, $this -> time);
		$database -> removeActiveGuest($_SERVER['REMOTE_ADDR']);

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

		/* Login completed successfully */
		return true;
	}

	/**
	 * logout - Gets called when the user wants to be logged out of the
	 * website. It deletes any cookies that were stored on the users
	 * computer as a result of him wanting to be remembered, and also
	 * unsets session variables and demotes his user level to guest.
	 */
	function logout() {
		global $database;
		//The database connection
		/**
		 * Delete cookies - the time must be in the past,
		 * so just negate what you added when creating the
		 * cookie.
		 */
		if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
			setcookie("cookname", "", time() - COOKIE_EXPIRE, COOKIE_PATH);
			setcookie("cookid", "", time() - COOKIE_EXPIRE, COOKIE_PATH);
		}

		/* Unset PHP session variables */
		unset($_SESSION['username']);
		unset($_SESSION['userid']);

		/* Reflect fact that user has logged out */
		$this -> logged_in = false;

		/**
		 * Remove from active users table and add to
		 * active guests tables.
		 */
		$database -> removeActiveUser($this -> username);
		$database -> addActiveGuest($_SERVER['REMOTE_ADDR'], $this -> time);

		/* Set user level to guest */
		$this -> username = GUEST_NAME;
		$this -> userlevel = GUEST_LEVEL;
	}

	/**
	 * register - Gets called when the user has just submitted the
	 * registration form. Determines if there were any errors with
	 * the entry fields, if so, it records the errors and returns
	 * 1. If no errors were found, it registers the new user and
	 * returns 0. Returns 2 if registration failed.
	 */
	function addnewuser($subuser, $subpass, $passconfirm, $birth_day, $birth_month, $birth_year, $subemail, $emailconfirm, $captcha_code, $captcha, $recaptchachallenge, $recaptcharesponse) {
		global $database, $dmsForm, $mailer;
		//The database, form and mailer object

		/* Username error checking */
		$field = "user";
		//Use field name for username
		if (!$subuser || strlen($subuser = trim($subuser)) == 0) {
			$dmsForm -> setError($field, "* Username not entered");
		} else {
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if (strlen($subuser) < 5) {
				$dmsForm -> setError($field, "* Username below 5 characters");
			} else if (strlen($subuser) > 30) {
				$dmsForm -> setError($field, "* Username above 30 characters");
			}
			/* Check if username is not alphanumeric */
			else if (!eregi("^([0-9a-z])+$", $subuser)) {
				$dmsForm -> setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if (strcasecmp($subuser, GUEST_NAME) == 0) {
				$dmsForm -> setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if ($database -> usernameTaken($subuser)) {
				$dmsForm -> setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if ($database -> usernameBanned($subuser)) {
				$dmsForm -> setError($field, "* Username banned");
			}
		}

		/* Password error checking */
		$field = "pass";
		//Use field name for password
		if (!$subpass) {
			$dmsForm -> setError($field, "* Password not entered");
		} else {
			/* Spruce up password and check length */
			$subpass = stripslashes($subpass);
			if (strlen($subpass) < 4) {
				$dmsForm -> setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if (!eregi("^([0-9a-z])+$", ($subpass = trim($subpass)))) {
				$dmsForm -> setError($field, "* Password not alphanumeric");
			}

			/**
			 * Note: I trimmed the password only after I checked the length
			 * because if you fill the password field up with spaces
			 * it looks like a lot more characters than 4, so it looks
			 * kind of stupid to report "password too short".
			 */
		}

		/* Password if confirmed */
		$field = "passconfirm";
		if (!$passconfirm) {
			$dmsForm -> setError($field, "* Password Confirm not entered");
		} elseif ($passconfirm != $subpass) {
			$dmsForm -> setError($field, "* Password Confirm does not match");
		}

		/* Email error checking */
		$field = "email";
		//Use field name for email
		if (!$subemail || strlen($subemail = trim($subemail)) == 0) {
			$dmsForm -> setError($field, "* Email not entered");
		} else {
			/* Check if valid email address */
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*" . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*" . "\.([a-z]{2,}){1}$";
			if (!eregi($regex, $subemail)) {
				$dmsForm -> setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Password if confirmed */
		$field = "emailconfirm";
		if (!$emailconfirm) {
			$dmsForm -> setError($field, "* Email Confirm not entered");
		} elseif ($emailconfirm != $subemail) {
			$dmsForm -> setError($field, "* Email Confirm does not match");
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
		/* No errors, add the new account to the */
		else {
			if ($database -> adminaddNewUser($subuser, md5($subpass), $birth_day, $birth_month, $birth_year, $subemail)) {

				// Make it were it sends the info to the new users email thats in the plans!
				//$mailer->sendActivation($subuser, $subemail, $subpass);

				return 0;
				//New user added succesfully
			} else {
				return 2;
				//Registration attempt failed
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
	}

	/**
	 * Config -
	 */
	function addconfig($sitename, $siteurl, $timezone, $timeformat, $captcha, $public_key, $private_key, $theme_name, $track_visitors, $cookieexpire, $cookiepath, $emailfromname, $emailfromaddress, $emailwelcome) {
		global $database, $dmsForm, $mailer;
		//The database, form and mailer object

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
		/* No errors, add the new account to the */
		else {
			if (!$database -> addconfig($sitename, $siteurl, $timezone, $timeformat, $captcha, $public_key, $private_key, $theme_name, $track_visitors, $cookieexpire, $cookiepath, $emailfromname, $emailfromaddress, $emailwelcome)) {
				$field = "settingssuccess";
				$dmsForm -> setError($field, "Settings successfully Set");
				return 0;
				//New Config added succesfully
			} else {
				$field = "settingsfailed";
				$dmsForm -> setError($field, "Settings failed to Set");
				return 2;
				//Config attempt failed
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
	}

	/**
	 * register - Gets called when the user has just submitted the
	 * registration form. Determines if there were any errors with
	 * the entry fields, if so, it records the errors and returns
	 * 1. If no errors were found, it registers the new user and
	 * returns 0. Returns 2 if registration failed.
	 */
	function register($subuser, $subpass, $passconfirm, $birth_day, $birth_month, $birth_year, $subemail, $emailconfirm, $captcha_code, $captcha, $recaptchachallenge, $recaptcharesponse) {
		global $database, $dmsForm, $mailer;
		//The database, form and mailer object

		/* Username error checking */
		$field = "user";
		//Use field name for username
		if (!$subuser || strlen($subuser = trim($subuser)) == 0) {
			$dmsForm -> setError($field, "* Username not entered");
		} else {
			/* Spruce up username, check length */
			$subuser = stripslashes($subuser);
			if (strlen($subuser) < 5) {
				$dmsForm -> setError($field, "* Username below 5 characters");
			} else if (strlen($subuser) > 30) {
				$dmsForm -> setError($field, "* Username above 30 characters");
			}
			/* Check if username is not alphanumeric */
			else if (!preg_match("/^[a-z0-9]+([\\s]{1}[a-z0-9]|[a-z0-9])+$/i", $subuser)) {
				$dmsForm -> setError($field, "* Username not alphanumeric");
			}
			/* Check if username is reserved */
			else if (strcasecmp($subuser, GUEST_NAME) == 0) {
				$dmsForm -> setError($field, "* Username reserved word");
			}
			/* Check if username is already in use */
			else if ($database -> usernameTaken($subuser)) {
				$dmsForm -> setError($field, "* Username already in use");
			}
			/* Check if username is banned */
			else if ($database -> usernameBanned($subuser)) {
				$dmsForm -> setError($field, "* Username banned");
			}
		}

		/* Password error checking */
		$field = "pass";
		//Use field name for password
		if (!$subpass) {
			$dmsForm -> setError($field, "* Password not entered");
		} else {
			/* Spruce up password and check length */
			$subpass = stripslashes($subpass);
			if (strlen($subpass) < 4) {
				$dmsForm -> setError($field, "* Password too short");
			}
			/* Check if password is not alphanumeric */
			else if (!eregi("^([0-9a-z])+$", ($subpass = trim($subpass)))) {
				$dmsForm -> setError($field, "* Password not alphanumeric");
			}

			/**
			 * Note: I trimmed the password only after I checked the length
			 * because if you fill the password field up with spaces
			 * it looks like a lot more characters than 4, so it looks
			 * kind of stupid to report "password too short".
			 */
		}

		/* Password if confirmed */
		$field = "passconfirm";
		if (!$passconfirm) {
			$dmsForm -> setError($field, "* Password Confirm not entered");
		} elseif ($passconfirm != $subpass) {
			$dmsForm -> setError($field, "* Password Confirm does not match");
		}

		/* Email error checking */
		$field = "email";
		//Use field name for email
		if (!$subemail || strlen($subemail = trim($subemail)) == 0) {
			$dmsForm -> setError($field, "* Email not entered");
		} else {
			/* Check if valid email address */
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*" . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*" . "\.([a-z]{2,}){1}$";
			if (!eregi($regex, $subemail)) {
				$dmsForm -> setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Password if confirmed */
		$field = "emailconfirm";
		if (!$emailconfirm) {
			$dmsForm -> setError($field, "* Email Confirm not entered");
		} elseif ($emailconfirm != $subemail) {
			$dmsForm -> setError($field, "* Email Confirm does not match");
		}

		/* Checks to see if the text_box_captcha is empty */
		/* $field = "text_box_captcha";
		 if ($text_box_captcha == 'Please remove all of this text') {
		 $dmsForm->setError($field, "* If your not a bot please be a human and remove all of the text.");
		 } else {
		 // Your code here to handle a successful verification
		 } */

		if (captcha == 'check_box') {
			$field = "captcha_ver";
			if ($captcha != 'checked') {
				$dmsForm -> setError($field, "* Check the box if your a human next time");
			}
		} else if (captcha == 'reCAPTCHA') {
			require_once ('recaptchalib.php');
			$privatekey = private_key;
			$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $recaptchachallenge, $recaptcharesponse);
			$field = "recaptcha";
			//Error: Out for the Recaptcha on the user field
			if (!$resp -> is_valid) {
				// What happens when the CAPTCHA was entered incorrectly
				$dmsForm -> setError($field, "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp -> error . ")");
			} else {
				// Your code here to handle a successful verification
			}
		} else if (captcha == 'captcha') {
			require_once 'libs/securimage/securimage.php';

			$image = new Securimage();

			// Code Validation

			$field = "securimage";
			if ($image -> check($captcha_code) == true) {
				// Your code here to handle a successful verification
			} else {
				$dmsForm -> setError($field, "* The CAPTCHA wasn't entered correctly. Go back and try it again.");
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
		/* No errors, add the new account to the */
		else {
			if ($database -> addNewUser($subuser, md5($subpass), $birth_day, $birth_month, $birth_year, $subemail)) {

				$mailer -> sendActivation($subuser, $subemail, $subpass);

				return 0;
				//New user added succesfully
			} else {
				return 2;
				//Registration attempt failed
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
	}

	function insertpm($to_user, $from_user, $subject, $message, $time) {
		global $database, $dmsForm, $mailer;
		//The database, form and mailer object

		/* Check to see if the message field is not empty */
		$field = "messageurself";
		if ($from_user == $to_user) {
			$dmsForm -> setError($field, "* You can't message yourself sorry!");
		}

		/* Check to see if user field is not empty */
		$field = "to_user";
		if (!$subject) {
			$dmsForm -> setError($field, "* User not entered");
		}

		/* Check to see if subject field is not empty */
		$field = "subject";
		if (!$to_user) {
			$dmsForm -> setError($field, "* Subject not entered");
		}

		/* Check to see if the message field is not empty */
		$field = "message";
		if (!$message) {
			$dmsForm -> setError($field, "* Message not entered");
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
		/* No errors, add the new pm to the database */
		else {
			if ($database -> insertpm($to_user, $from_user, $subject, $message, $time)) {
				$field = "success";
				$dmsForm -> setError($field, "Message sent sucessfully");
				return 0;
				//added succesfully
			} else {
				return 2;
				//attempt failed
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return 1;
			//Errors with form
		}
	}

	/**
	 * editAccount - Attempts to edit the user's account information
	 * including the password, which it first makes sure is correct
	 * if entered, if so and the new password is in the right
	 * format, the change is made. All other fields are changed
	 * automatically.
	 */
	function admineditAccount($subuser, $subemail, $userlevels) {
		global $database, $dmsForm;
		//The database and form object
		/* New username entered */
		if ($subuser) {
			/* New Username error checking */
			$field = "username";
			//Use field name for new username
			if (strlen($subuser) < 4) {
				$dmsForm -> setError($field, "* New Username too short");
			}
		}
		/* Change username attempted */
		else if ($subuser) {
			/* New Password error reporting */
			$field = "username";
			//Use field name for new password
			$dmsForm -> setError($field, "* New Username not entered");
		}

		/* Email error checking */
		$field = "email";
		//Use field name for email
		if ($subemail && strlen($subemail = trim($subemail)) > 0) {
			/* Check if valid email address */
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*" . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*" . "\.([a-z]{2,}){1}$";
			if (!eregi($regex, $subemail)) {
				$dmsForm -> setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return false;
			//Errors with form
		}

		/* Update username since there were no errors */
		if ($subuser) {
			$database -> updateUserField($this -> username, "username", $subuser);
		}

		/* Change Email */
		if ($subemail) {
			$database -> updateUserField($this -> username, "email", $subemail);
		}

		/* Update userlevels since there were no errors */
		if ($userlevels) {
			$database -> updateUserField($this -> username, "userlevel", $userlevels) or die(mysqli_error());
		}

		/* Success! */
		return true;
	}

	/* process and check for errors on new pass */
	function admineditnewpass($subnewpass) {
		global $database, $dmsForm;
		//The database and form object

		/* New password entered */
		if ($subnewpass) {
			/* New Password error checking */
			$field = "newpass";
			//Use field name for new password
			/* Spruce up password and check length */
			$subpass = stripslashes($subnewpass);
			if (strlen($subnewpass) < 4) {
				$dmsForm -> setError($field, "* New Password too short");
			}
			/* Check if password is not alphanumeric */
			else if (!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))) {
				$dmsForm -> setError($field, "* New Password not alphanumeric");
			}
		}
		/* Change password attempted */
		else if ($subnewpass) {
			/* New Password error reporting */
			$field = "newpass";
			//Use field name for new password
			$dmsForm -> setError($field, "* New Password not entered");
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return false;
			//Errors with form
		}

		/* Update password since there were no errors */
		if ($subnewpass) {
			$database -> updateUserField($this -> username, "password", md5($subnewpass));
		}

		/* Success! */
		return true;
	}

	/**
	 * editAccount - Attempts to edit the user's account information
	 * including the password, which it first makes sure is correct
	 * if entered, if so and the new password is in the right
	 * format, the change is made. All other fields are changed
	 * automatically.
	 */
	function editAccount($filefield, $subcurpass, $subnewpass, $subemail, $subbio, $subps) {
		global $database, $dmsForm;
		//The database and form object
		/* New password entered */
		if ($subnewpass) {
			/* Current Password error checking */
			$field = "curpass";
			//Use field name for current password
			if (!$subcurpass) {
				$dmsForm -> setError($field, "* Current Password not entered");
			} else {
				/* Check if password too short or is not alphanumeric */
				$subcurpass = stripslashes($subcurpass);
				if (strlen($subcurpass) < 4 || !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))) {
					$dmsForm -> setError($field, "* Current Password incorrect");
				}
				/* Password entered is incorrect */
				if ($database -> confirmUserPass($this -> username, md5($subcurpass)) != 0) {
					$dmsForm -> setError($field, "* Current Password incorrect");
				}
			}

			/* New Password error checking */
			$field = "newpass";
			//Use field name for new password
			/* Spruce up password and check length */
			$subpass = stripslashes($subnewpass);
			if (strlen($subnewpass) < 4) {
				$dmsForm -> setError($field, "* New Password too short");
			}
			/* Check if password is not alphanumeric */
			else if (!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))) {
				$dmsForm -> setError($field, "* New Password not alphanumeric");
			}
		}
		/* Change password attempted */
		else if ($subcurpass) {
			/* New Password error reporting */
			$field = "newpass";
			//Use field name for new password
			$dmsForm -> setError($field, "* New Password not entered");
		}

		/* Email error checking */
		$field = "email";
		//Use field name for email
		if ($subemail && strlen($subemail = trim($subemail)) > 0) {
			/* Check if valid email address */
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*" . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*" . "\.([a-z]{2,}){1}$";
			if (!eregi($regex, $subemail)) {
				$dmsForm -> setError($field, "* Email invalid");
			}
			$subemail = stripslashes($subemail);
		}

		/* Bio Errors */
		$field = "bio";
		if ($subbio) {
			if (empty($subbio)) {
				$dmsForm -> setError($field, "* Bio not entered");
			}

			if ($subbio > 255) {
				$dmsForm -> setError($field, "* To long of bio");
			}
			$subbio = $subbio;
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return false;
			//Errors with form
		}

		/* Update password since there were no errors */
		if ($subcurpass && $subnewpass) {
			$database -> updateUserField($this -> username, "password", md5($subnewpass));
		}

		/* Change Email */
		if ($subemail) {
			$database -> updateUserField($this -> username, "email", $subemail);
		}

		if ($subbio) {
			$database -> updateUserField($this -> username, "bio", $subbio);
		}

		if ($subps) {
			$database -> updateUserField($this -> username, "profile_status", $subps);
		}

		/* Success! */
		return true;
	}

	function avatarupload($filefield_tmpname, $filefield_name, $filefield_size) {
		global $dmsForm;
		// If a file is posted with the form
		if ($filefield_tmpname != "") {
			$maxfilesize = 51200;
			// 51200 bytes equals 50kb
			if ($filefield_size > $maxfilesize) {
				$field = "filefield";
				$dmsForm -> setError($field, "* Your image was too large, please try again.");
				unlink($filefield_tmpname);
			} else if (!preg_match("/\.(gif|jpg|png)$/i", $filefield_name)) {
				$field = "filefield";
				$dmsForm -> setError($field, "* Your image was not one of the accepted formats, please try again.");
				unlink($filefield_tmpname);
			} else {
				$uploaddir = "useruploads";
				if (file_exists("$uploaddir/" . $this -> id . "")) {
					$uploaddir = "useruploads";
					$newname = "image01.jpg";
					$place_file = move_uploaded_file($filefield_tmpname, "$uploaddir/" . $this -> id . "/" . $newname);
				} else {
					$uploaddir = "useruploads";
					mkdir($uploaddir . "/" . $this -> id . "", 0777);
					$newname = "image01.jpg";
					$place_file = move_uploaded_file($filefield_tmpname, "$uploaddir/" . $this -> id . "/" . $newname);
				}
			}
		}

		/* Errors exist, have user correct them */
		if ($dmsForm -> num_errors > 0) {
			return false;
			//Errors with form
		}

		/* Success! */
		return true;
	}

	/**
	 * isAdmin - Returns true if currently logged in user is
	 * an administrator, false otherwise.
	 */
	function isAdmin() {
		return ($this -> userlevel == ADMIN_LEVEL || $this -> username == ADMIN_NAME);
	}

	/**
	 * generateRandID - Generates a string made up of randomized
	 * letters (lower and upper case) and digits and returns
	 * the md5 hash of it to be used as a userid.
	 */
	function generateRandID() {
		return md5($this -> generateRandStr(16));
	}

	/**
	 * generateRandStr - Generates a string made up of randomized
	 * letters (lower and upper case) and digits, the length
	 * is a specified parameter.
	 */
	function generateRandStr($length) {
		$randstr = "";
		for ($i = 0; $i < $length; $i++) {
			$randnum = mt_rand(0, 61);
			if ($randnum < 10) {
				$randstr .= chr($randnum + 48);
			} else if ($randnum < 36) {
				$randstr .= chr($randnum + 55);
			} else {
				$randstr .= chr($randnum + 61);
			}
		}
		return $randstr;
	}

};

/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;

/* Initialize form object */
$dmsForm = new dmsForm;

ob_flush();
?>