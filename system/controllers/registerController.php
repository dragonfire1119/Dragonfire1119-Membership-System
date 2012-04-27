<?php
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 *
 */
class registerController extends Dms {

	function __construct() {

	}

	public function load() {

		global $users, $dms, $session;

		if (isset($_POST["form"])) {
			if (Form::isValid($_POST["form"])) {
				/*The form's submitted data has been validated.  Your script can now proceed with any
				 further processing required.*/
				$users -> doregister($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passconfirm'], $_POST['gravatar'], $_POST['dateofbirth']);
				//header("Location: " . $_SERVER["PHP_SELF"]);
			} else {
				/*Validation errors have been found.  We now need to redirect back to the
				 script where your form exists so the errors can be corrected and the form
				 re-submitted.*/
				header("Location: " . $_SERVER["PHP_SELF"]);
			}
			exit();
		}

		echo "
<style type=\"text/css\">
.info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
}
.info {
    color: #00529B;
    background-color: #BDE5F8;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/info.png');
}
.success {
    color: #4F8A10;
    background-color: #DFF2BF;
    background-image:url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/success.png');
}
.warning {
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/warning.png');
}
.error {
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('" . $dms -> url() . COOKIE_PATH . "system/includes/images/error.png');
}
</style>
";

		if (isset($_GET['error_register']) AND $_GET['error_register'] == 1) {
			echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
			<ul>
			<li>
			Email is already in use
			</li>
			</ul></div>";
		} else if (isset($_GET['error_register']) AND $_GET['error_register'] == 2) {
			echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
			<ul>
			<li>
			Username is already in use
			</li>
			</ul></div>";
		} else if (isset($_GET['error_register']) AND $_GET['error_register'] == 3) {
			echo "<div class='error'><font size=\"2\" color=\"#ff0000\">1 error(s) found</font>
			<ul>
			<li>
			Password and Password Confirm do not match
			</li>
			</ul></div>";
		} else if (isset($_GET['success'])) {
			echo "<div class='success'>
			<ul>
			You have successfully logged in.
			</ul></div>";
		}

		$this -> load_view("register");
	}

}

$register = new registerController;
