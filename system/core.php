<?php

/**
 * Tell the system that this is DMS reading the pages instead of somebody in the browser
 */
define("DMS", 1);

/**
 * Check if DMS needs to be installed
 */
/*if (file_exists("install.php")) {
	header("Location: install.php");
	exit ;
}

/**
 * Start configs
 */
require_once ("config/db_Config.php");
require_once ("config/DMS_Config.php");

/**
 * Start Libs
 */
require_once ("libs/gravatar/gravatar.php");
require_once ("libs/PFBC/Form.php");
require_once ("libs/redbeanphp/rb.php");
//require_once("libs/securimage/securimage.php");
require_once ("libs/swiftmailer/swift_required.php");

/**
 * Start Includes
 */
require_once ("includes/dms.php");
require_once ("includes/session.php");

/**
 * Start Models
 */
require_once ("models/mainModel.php");
require_once ("models/pmModel.php");
require_once ("models/usersModel.php");

/**
 * Start Controllers
 */
require_once ("controllers/loginController.php");
require_once ("controllers/logoutController.php");
require_once ("controllers/pmController.php");
require_once ("controllers/profileController.php");
require_once ("controllers/registerController.php");
