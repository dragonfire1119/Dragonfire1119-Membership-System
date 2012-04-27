<?php

/**************************************************************************
 * Dragonfire1119 Membership System AKA DMS
 * Copyright (C) 2012  Christopher Hicks
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 **************************************************************************/

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
