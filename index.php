<?php

define("DMS_SECURITY", 1);

include ("app/core.php");
echo $html -> doctype;
echo $html -> html;
echo $html -> head;
$html -> title("Login");
echo $html -> endhead;
echo $html -> body;
echo $session -> username;
if (isset($_GET['login'])) {
	$login -> render("index.php?login");
} else if (isset($_GET['logout'])) {
	$logout -> render();
} else if (isset($_GET['register'])) {
	$register->render();
}
echo $html -> endbody;
echo $html -> endhtml;
?>