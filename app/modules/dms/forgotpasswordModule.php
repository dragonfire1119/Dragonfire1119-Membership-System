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

class forgotpasswordModule {

	function __construct() {

	}

	function render() {
		global $dmsForm, $security;

		echo $security -> checkifactivated();
		$filename = "install.php";
		if (file_exists($filename)) {
			header("Location: install.php?install=true");
		}
		/**
		 * Forgot Password form has been submitted and no errors
		 * were found with the form (the username is in the database)
		 */
		if (isset($_SESSION['forgotpass'])) {
			/**
			 * New password was generated for user and sent to user's
			 * email address.
			 */
			if ($_SESSION['forgotpass']) {
				include_once("app/design/default/forgotpassword/forgotpasswordPasswordGenerated.php");
			}
			/**
			 * Email could not be sent, therefore password was not
			 * edited in the database.
			 */
			else {
				include_once("app/design/default/forgotpassword/forgotpasswordFailure.php");
			}

			unset($_SESSION['forgotpass']);
		} else {

			/**
			 * Forgot password form is displayed, if error found
			 * it is displayed.
			 */
			include_once("app/design/default/forgotpassword/forgotpasswordDesign.php");
		}
	}

}

$forgotpassword = new forgotpasswordModule;
