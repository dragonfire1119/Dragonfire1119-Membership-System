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

include_once("system.php");

/*
 * Start loading modules here
 * Set the load to TRUE if you want it active
 * Set it to FALSE if you want it deactivated
 * By default if TRUE or FALSE is not present it will be set to TRUE by default
 */
include(DIR_MODULES . "/dms/DMS_loader.php");

?>