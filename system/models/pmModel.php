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
class pmModel extends mainModel {

	function __construct() {

	}

	public function dosend($from, $to, $message) {
		global $mainModel;

		$this -> connect();

		//call safestrip function
		$santized_email = filter_var($from, FILTER_SANITIZE_EMAIL);

		// check if the user id and password combination exist in database
		$sql = R::getAll("SELECT * FROM users WHERE username = '$to'");

		if (!$sql || (count($sql) < 1)) {

			header('Location: ?error_send=1');
		} else {
			$pm = R::dispense('private_messages');
			$pm -> from = $from;
			$pm -> to = $to;
			$pm -> message = $message;
			$id = R::store($pm);
		}

	}
	
	public function doreply($from, $to, $message) {
		global $mainModel;

		$this -> connect();

		//call safestrip function
		$santized_email = filter_var($from, FILTER_SANITIZE_EMAIL);

		// check if the user id and password combination exist in database
		$sql = R::getAll("SELECT * FROM users WHERE username = '$to'");

		if (!$sql || (count($sql) < 1)) {

			header('Location: ?error_send=1');
		} else {
			$pm = R::dispense('private_messages');
			$pm -> subject = $from;
			$pm -> from = $from;
			$pm -> to = $to;
			$pm -> message = $message;
			$id = R::store($pm);
		}

	}

}

$pmmodel = new pmModel;
?>