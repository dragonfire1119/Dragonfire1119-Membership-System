<?php
if (!defined("DMS")) {
	die("You can't access this");
}

/**
 *
 */
class mainModel {

	public $connect;

	function __construct() {
		
	}
	
	public function connect() {
		if (DB_TYPE == "mysql") {
			$this -> connect = R::setup('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . '', '' . DB_USER . '', '' . DB_PASS . '');
		} else if (DB_TYPE == "postgresql") {
			$this -> connect = R::setup('pgsql:host=' . DB_SERVER . ';dbname=' . DB_NAME . '', '' . DB_USER . '', '' . DB_PASS . '');
		} else if (DB_TYPE == "sqllite") {
			$this -> connect = R::setup('sqlite:/tmp/dbfile.txt', '' . DB_USER . '', '' . DB_PASS . '');
		} else if (DB_TYPE == "cubrid") {
			$this -> connect = R::setup('cubrid:host=' . DB_SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . '', '' . DB_USER . '', '' . DB_PASS . '');
		}
	}

}
