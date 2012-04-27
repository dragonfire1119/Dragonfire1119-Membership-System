<?php
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 * 
 */
class profileController extends Dms {

	function __construct() {

	}

	public function load() {
		global $dms, $session;
		
		$dms -> load_view("profile");
	}
	
	public function avatar() {
		
	}

}

$profile = new profileController;
