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

define("DMS_SECURITY", 1);

include ("app/core.php");
echo $html -> doctype;
echo $html -> html;
echo $html -> head;
$html -> title("Login");
echo $html -> endhead;
echo $html -> body;
if (isset($_GET['action']) AND $_GET['action'] == "login") {
	$login -> render("login");
} else if (isset($_GET['action']) AND $_GET['action'] == "logout") {
	$logout -> render();
} else if (isset($_GET['action']) AND $_GET['action'] == "register") {
	$register -> render();
} else if (isset($_GET['action']) AND $_GET['action'] == "messages") {
	$checks -> render("checklogin", "login");
	$pm -> render("messagesender", $session -> username);
} else if (isset($_GET['profile']) AND $_GET['profile'] == $session->username) {
	echo $session->username;
	echo $session->userid;
} else if (isset($_GET['edit']) AND $_GET['edit'] == $session->username) {
	
}
echo $html -> endbody;
echo $html -> endhtml;
?>