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

class loginModule {

	function __construct() {

	}

	function render($redirect="") {
		global $dmsForm, $form, $dms;
		if ($dmsForm -> num_errors > 0) {
			echo "<div class='pfbc-error ui-state-error ui-corner-all'><font size=\"2\" color=\"#ff0000\">" . $dmsForm -> num_errors . " error(s) found</font>
			<ul>"; if ($dmsForm -> error("user")) { echo "<li>" . $dmsForm -> error("user"). "</li>"; } echo "
			"; if ($dmsForm -> error("pass")) { echo "<li>" . $dmsForm -> error("pass") . "</li>"; } echo "</ul></div>";
		}
		$location = "process.php";
		$options = array("Remember Me?");
		$form = new Form("layout_standard", 300, $location);
		$form -> addElement(new Element_Hidden("form", "layout_standard"));
		$form -> addElement(new Element_Textbox("Username:", "user", array(
    "value" => $dmsForm -> value("user")
)));
		$form -> addElement(new Element_Password("Password:", "pass", array(
    "value" => $dmsForm -> value("pass")
)));
		$form->addElement(new Element_Checkbox("", "remember", $options));
		$form -> addElement(new Element_Button("Login", "submit", array("icon" => "key")));
		$form->addElement(new Element_Hidden("sublogin", "sublogin"));
		$form->addElement(new Element_Hidden("subredirect", $redirect));
		$form -> render();
		echo $dms->poweredby();
	}

}

$login = new loginModule;
