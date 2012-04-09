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

// Checks to see if nobody is directly accessing the file
if (!defined('DMS_SECURITY')) {
	die('Hacking attempt...');
}

/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASSS", "");
define("DB_NAME", "dms");
define("DB_TYPE", "mysql");

/*
 * The theme loader
 */
define("dms_theme_name", "dms_theme");

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS", "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS", "banned_users");
define("TBL_PM", "private_messages");
define("TBL_FRIENDREQUESTS", "friends_requests");
define("TBL_CONFIG", "config");
define("TBL_ACTIVEUSERS", "active_users");

/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define("ADMIN_NAME", "admin");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("USER_LEVEL", 1);
define("GUEST_LEVEL", 0);

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

/**
 * Page config - These are not going to be developed anymore
 * These will be replaced if I add the paging system
 */
define("page_main", "Index");
define("page_forgotpass", "Forgot Password");
define("page_register", "Register");
define("page_useredit", "User Edit");
define("page_userinfo", "User Info");

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
define("TRACK_VISITORS", true);
?>