<?php

/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("MYSQL_HOST", "127.0.0.1");
define("MYSQL_DB", "dms");
define("MYSQL_USER", "root");
define("MYSQL_PASSWORD", "");

define("SITE_NAME", "DMS");

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
 * @param reCaptcha private key
 * @param reCapthca public key
 */
define("privateKey", "6LcazwoAAAAAAD-auqUl-4txAK3Ky5jc5N3OXN0_");
define("publicKey", "6LcazwoAAAAAADamFkwqj5KN1Gla7l4fpMMbdZfi");
 
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

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

/*
 * This is all the paths to directorys
 */
define("DESIGN_DIR", "design/");
define("THEME_DIR", DESIGN_DIR . "default/");
define("LOGIN_DIR", THEME_DIR . "login/");
define("REGISTER_DIR", THEME_DIR . "register/");
?>