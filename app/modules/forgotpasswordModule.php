<?php

/**
 *
 */
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
