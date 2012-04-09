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

class checksModule {
	
	function __construct() {
		
	}
	
	public function render($type, $username, $redirect=NULL) {
		
		switch ($type) {
			case "checklogin" :
				$this -> checklogin($username, $redirect);
				break;
			default :
				die("You have to pick what type over module you want in $pm->render();");
		}
	}
	
	private function checklogin($username=NULL, $redirect=NULL) {
		global $session;
		if (!$session->logged_in) {
			header("Location: " . $redirect);
		}
	}
}

$checks = new checksModule;
?>
