<?php
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 *
 */
class Dms {

	var $connect;
	var $data = array();
	var $userdata = array();

	function __construct() {
		//$this->connect = R::setup('mysql:host='.DB_SERVER.';dbname='.DB_NAME.'',''.DB_USER.'',''.DB_PASS.'');
	}

	public function load_view($load) {
		include_once ("system/views/" . $load . ".php");
	}

	function url() {
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = $this -> strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
	}

	function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}

}

$dms = new Dms;
