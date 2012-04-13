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

class registerModule {

	function __construct() {

	}

	public function render() {
		global $session, $database, $dmsForm, $security;
		echo $security -> checkifactivated();
		$filename = "install.php";
		if (file_exists($filename)) {
			header("Location: install.php?install=true");
		}
		if (!$session -> logged_in) {
			/**
			 * The user is already logged in, not allowed to register.
			 */
			if ($session -> logged_in) {
				echo "" . registeralready . "";
				echo "" . regsiteredalreadymessage . "";
			}
			/**
			 * The user has submitted the registration form and the
			 * results have been processed.
			 */
			else if (isset($_SESSION['regsuccess'])) {
				/* Registration was successful */
				if ($_SESSION['regsuccess'] == true) {
					include_once ("app/design/default/register/registerSuccess.php");
				}
				/* Registration failed */
				else if ($_SESSION['regsuccess'] == false) {
					include_once ("app/design/default/register/registerFailure.php");
				}
				unset($_SESSION['regsuccess']);
				unset($_SESSION['reguname']);
			}
			/**
			 * The user has not filled out the registration form yet.
			 * Below is the page with the sign-up form, the names
			 * of the input fields are important and should not
			 * be changed.
			 */
			else {

				echo '' . registerheadmessage . '';

				if ($dmsForm -> num_errors > 0) {
					echo "<br /><td><font size=\"2\" color=\"#ff0000\">" . $dmsForm -> num_errors . " error(s) found</font></td>";
				}

				echo '<script type="text/javascript">';
				echo 'var RecaptchaOptions = {';
				echo "theme : '" . theme_name . "'";
				echo "};";
				echo "</script>";

				$options = array(captchacheckboxmessage);
				$form = new Form("elements", 400, "process.php");
				$form -> configure(array("view" => new View_Grid( array(1, 2, 1, 2))));
				$form -> addElement(new Element_Hidden("form", "elements"));
				$form -> addElement(new Element_Textbox(username, "user"));
				$form -> addElement(new Element_Password(password, "pass"));
				$form -> addElement(new Element_Password(passwordconfirm, "passconfirm"));
				$form -> addElement(new Element_Date(dateofbirth, "dateofbirth", array("value" => "00/00/0000")));
				$form -> addElement(new Element_Email(email, "email"));
				$form -> addElement(new Element_Email(emailconfirm, "emailconfirm"));
				if (captcha == 'check_box') {
					$form -> addElement(new Element_Checkbox("", "captcha", $options));
				} else if (captcha == 'reCAPTCHA') {
					$form -> addElement(new Element_Captcha("Captcha:"));
				} else {
					$form -> addElement(new Element_Hidden("honeypot", ""));
				}
				$form -> addElement(new Element_Hidden("subjoin", ""));
				$form -> addElement(new Element_Button);
				$form -> render();
			}

		}
	}

}

$register = new registerModule;
?>