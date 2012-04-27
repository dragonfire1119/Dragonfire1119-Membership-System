<?php
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 *
 */
class pmController extends Dms {

	function __construct() {

	}

	public function load() {

		global $users, $dms;

	}

	public function send() {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			if (isset($_POST['subsend'])) {
				$pmmodel -> dosend($_POST['from'], $_POST['to'], $_POST['message']);
			}
			$this->data['email'] = $session->email;
			$this -> load_view("send");
		} else {
			echo "You do not have access sorry.";
		}

	}
	
	public function reply() {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			if (isset($_POST['subsend'])) {
				$pmmodel -> dosend($_POST['from'], $_POST['to'], $_POST['message']);
			}
			$this->data['email'] = $session->email;
			$this -> load_view("send");
		} else {
			echo "You do not have access sorry.";
		}
		
	}
	
	public function messages($from, $to) {
		global $session, $pmmodel;

		if ($session -> checkifloggedin()) {
			$this->data['messages'] = $pmmodel -> getmessages($from, $to);
			$this -> load_view("messages");
		} else {
			echo "You do not have access sorry.";
		}
		
	}

}

$pm = new pmController;
