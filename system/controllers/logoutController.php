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
 * This is the logout controller it helps with puting the loggout function anywhere the core.php is
 */
class logoutController extends Dms {
	
	function __construct() {
		
	}

	public function load($location=NULL) {

		global $users, $dms;

		session_destroy();

		header("Location: " . $location);

	}

}

$logout = new logoutController;
