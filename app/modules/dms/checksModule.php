<?php

/**
 * 
 */
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
