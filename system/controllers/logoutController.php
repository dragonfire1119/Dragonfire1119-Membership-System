<?php
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
