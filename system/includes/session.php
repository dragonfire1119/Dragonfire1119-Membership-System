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
 * Start Session
 */
class Session extends Dms {

	public $id;
	public $username;
	public $email;
	public $userlevel;
	public $time;

	var $referrer;
	var $url;

	function __construct() {
		global $dms;

		$this -> time = time();
		$this -> startSession();

	}

	private function startSession() {
		session_start();

		$this -> checkifloggedin();

		/* Set referrer page */
		if (isset($_SESSION['url'])) {
			$this -> referrer = $_SESSION['url'];
		} else {
			$this -> referrer = "/";
		}

		/* Set current url */
		$this -> url = $_SESSION['url'] = $_SERVER['PHP_SELF'];

	}

	public function checkifloggedin() {
		global $usersModel;
		if (isset($_SESSION['authorized']) AND isset($_SESSION['success'])) {
			return 1;

			$usersModel -> updateonlinestatus();

			/* User is logged in, set class variables */
			foreach ($users->getUserInfo($_SESSION['username']) as $this->userinfo) {
				$this -> id = $this -> userinfo['id'];
				$this -> username = $this -> userinfo['username'];
				$this -> email = $this -> userinfo['email'];
				$this -> userlevel = $this -> userinfo['userlevel'];
			}
			return true;
		} else {
			return 0;

			$this -> id = $_SESSION['id'] = '100000000';
			$this -> email = $_SESSION['email'] = GUEST_NAME;
			$this -> userlevel = GUEST_LEVEL;
			$database -> addActiveGuest($_SERVER['REMOTE_ADDR'], $this -> time);
		}
	}

	public function error() {
		$message = '';
		if ($_SESSION['success'] != '') {
			$message = '<span class="success" id="message">' . $_SESSION['success'] . '</span>';
			$_SESSION['success'] = '';
		}
		if ($_SESSION['error'] != '') {
			$message = '<span class="error" id="message">' . $_SESSION['error'] . '</span>';
			$_SESSION['error'] = '';
		}
		return $message;
	}

}

$session = new Session;
