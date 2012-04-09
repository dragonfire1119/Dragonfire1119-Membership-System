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
 *------------------------------------------------------------------------------------------------*/
// Checks to see if nobody is directly accessing the file
if (!defined('DMS_SECURITY')) {
    die('Hacking attempt...');
}

/*
 * Author: Christopher Hicks
 * Type: English Edition
 * Version: 0.1
 */

/*
 * Starting of Memberlist Lang
 */

define("searchusersmessage", "Search Users: ");
define("errormessagedisplayingusers", "Error displaying users");
define("errornousers", "There is no users registed!");
define("tableusername", "Username");
define("tableedits", "Edits");

/*
 * Ending of Memberlist Lang
 */

/*
 * Starting of Register Lang
 */
// Main Register
define("registerheadmessage", "<h1>Register</h1><br />");

// Starting of form fields
define("username", "Username:");
define("password", "Password:");
define("passwordconfirm", "Password Confirm:");
define("dateofbirth", "Date of Birth: ");
define("email", "Email:");
define("emailconfirm", "Email Confirm:");
define("captchacheckboxmessage", "Check this if your a human");
// Starting of Errors

define("registeralready", "<h1>Registered Already!</h1>");
define("regsiteredalreadymessagebegin", "<p>We're sorry <b>$session->username</b>, but you've already registered. " . "<a href=\"index.php\">Main</a>.</p>");

// End of Errors

// Register Failed Messages

define("regsiterfailedh1", "<h1>Registration Failed</h1>");
define("regsiterfailedmessagebegin", "<p>We're sorry, but an error has occurred and your registration for the username <b>");
define("registerfailedmessageend", "</b>, could not be completed.<br>Please try again at a later time.</p>");

// End Register Failed Messages

// Success Messages
define("registersuccessh1", "<h1>Registered!</h1>");
define("registersuccessmessagebegin", "<p>Thank you <b>");
define("registersuccessmessageend", "</b>, your information has been added to the database, " . "There is one more step, check your email to very your account</p><a href=\"index.php\"> Go back to Login</a>");
// End Success Messages
/*
 * Ending of Register Lang
 */

/*
 * Starting of Login Lang
 */
define("loginusername", "Username:");
define("loginpassword", "Password:");
define("rememberme", "Remember me next time");
define("loginbutton", "Login");
define("forgotpassword", "[<a href=\"index.php?go=forgotpass\">Forgot Password?</a>]");
define("notregisted", "Not registered? <a href=\"register.php\">Sign-Up!</a>");
/*
 * Ending of Login Lang
 */

/*
 * Starting of Topbar Lang
 */

define("topbarwelcomemessage", "Welcome <b>$session->username</b>,");
define("homebutton", "Home");
define("myaccountbutton", "My Account");
define("editaccountbutton", "Edit Account");
define("pminboxbutton", "Inbox");
define("friendrequestsbuttton", "Friend Requests");
define("pmoutboxbutton", "Outbox");
define("pmsendbutton", "Compose");
define("memberlistbutton", "Members List");
define("dashboardbutton", "Dashboard");
define("logoutbutton", "Logout");

/*
 * Online Legend
 */
define("seealllist", "(See full list)");

/*
 * Ending of Topbar lang
 */
