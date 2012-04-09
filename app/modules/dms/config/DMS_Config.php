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

define("SITE_NAME", "DMS");

/**
 * @param reCaptcha private key
 * @param reCapthca public key
 */
define("privateKey", "6LcazwoAAAAAAD-auqUl-4txAK3Ky5jc5N3OXN0_");
define("publicKey", "6LcazwoAAAAAADamFkwqj5KN1Gla7l4fpMMbdZfi");

/**
 * Choose your captcha
 * @param check_box
 * @param reCAPTCHA
 * @param captcha
 */
define("captcha", "check_box");
 
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

// Please do not change this
// if you are going to delete this please donate to my development of DMS I take allot of time to make this
// DO NOT EDIT
define("POWERED_BY", '<p>Powered by <a href="http://dms.dragonfire1119.com/">Dragonfire1119 Membership Script</a></p>');
// END DO NOT EDIT
?>