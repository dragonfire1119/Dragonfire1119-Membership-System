<?php

/**
 *
 */
class logoutModule {

	function __construct() {

	}

	public function render($redirect = "") {
		global $session;
		// Call the logout function in session
		$retval = $session -> logout();
		
		// Check to see if $redirect is empty or not
		if (empty($redirect)) {
			header("Location: index.php");
		} else {
			header("Location: " . $redirect);
		}
	}

}

$logout = new logoutModule;
