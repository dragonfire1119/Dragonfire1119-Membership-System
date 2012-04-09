<?php

/* Dragonfire1119 Membership Script Beta 0.2
 * Copyright (c) 2011 Christopher Hicks
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: January 4, 2011
 * ------------------------------------------------------------------------------------------------ */
// Checks to see if nobody is directly accessing the file
if (!defined('DMS_SECURITY')) {
    die('Hacking attempt...');
}

/*
 * This is the ultimate core file this is the heart to DMS
 * If your not a developer don't touch this file this is a warning
 * These are loaded in a specific order to parse though the system you get one 
 * out of there spot and you could see a ton of errors
 * For support on the topic go to 
 * http://dms.dragonfire1119.com/forum/
 */

/**
 * Load the libs
 * 
 */
include_once("libs/PFBC/form.php");
include_once("libs/redbeanphp/rb.php");

/*
 * The core files - These are the core files do not touch this at all
 */
include_once("config_db.php");
include_once("includes/core/security.php");
include_once("includes/core/database.php");
include_once("includes/core/dmsform.php");
include_once("includes/core/session.php");
include_once("includes/core/dms.php");
include_once("includes/core/api.php");
include_once("DMS_Config.php");
include_once("includes/core/mailer.php");

/**
 * Load Modules
 */
include_once("modules/forgotpasswordModule.php");
include_once("modules/loginModule.php");
include_once("modules/logoutModule.php");
include_once("modules/registerModule.php");
 
/*
 * Load the Lang
 * You can load as many langs in here but what ever your not using put these in front of the
 * //include_once("whatever");
 */
include_once("includes/lang/english.lang.php");

/*
 * Loader all the modules - These are being slowly replaced by helpers now
 */
include_once("app/helpers/css.php");
include_once("app/helpers/html.php");
include_once("app/helpers/javascript.php");

/*
 * Libs - Do not touch this very important
 */
include_once("app/libs/securimage/securimage.php");

?>