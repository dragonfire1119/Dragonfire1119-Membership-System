<?php
/**************************************************************************
* Dragonfire1119 Membership System AKA DMS
* Copyright (C) 2012 Christopher Hicks
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

// Uncoment this if you want to debug
ini_set( 'display_errors', 1 );
ini_set( 'log_errors', 1 );
error_reporting( E_ALL );

/**
 * This is the main config file for DMS
 */
define("ABSPATH", dirname(__FILE__));

define("HOST", "localhost");
define("DBNAME", "");
define("USER", "");
define("PASSWORD", "");

R::setup('mysql:host='.HOST.';
        dbname='.DBNAME.'',''.USER.'',''.PASSWORD.'');