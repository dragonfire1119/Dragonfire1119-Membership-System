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
class pmController extends Dms {

	function __construct() {

	}

	public function load() {

		global $users, $dms;

	}

	public function send() {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			if (isset($_POST['subsend'])) {
				$pmmodel -> dosend($_POST['from'], $_POST['to'], $_POST['message']);
			}
			$this->data['email'] = $session->email;
			$this -> load_view("send");
		} else {
			echo "You do not have access sorry.";
		}

	}
	
	public function reply() {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			if (isset($_POST['subsend'])) {
				$pmmodel -> dosend($_POST['from'], $_POST['to'], $_POST['message']);
			}
			$this->data['email'] = $session->email;
			$this -> load_view("send");
		} else {
			echo "You do not have access sorry.";
		}
		
	}
	
	public function messages($from, $to) {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			$this->data['messages'] = $pmmodel -> getmessages($from, $to);
			$this -> load_view("messages");
		} else {
			echo "You do not have access sorry.";
		}
		
	}

}

$pm = new pmController;
