<?php

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