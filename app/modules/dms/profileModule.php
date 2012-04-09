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

class profileModule {

	function __construct() {

	}

	public function render() {

	}

	private function editprofile() {
		global $html;
		$form = new Form("layout_standard", 300, "process.php");
		$form -> addElement(new Element_Hidden("form", "layout_standard"));
		$form -> addElement(new Element_Textbox("Username:", "user"));
		$form -> addElement(new Element_Password("Current password:", "cpassword"));
		$form -> addElement(new Element_Textbox("New password:", "newpassword"));
		$form -> addElement(new Element_Textbox("Confirm new password:", "newpassword"));
		$form -> addElement(new Element_Checkbox("", "remember", $options));
		$form -> addElement(new Element_Button("Login", "submit", array("icon" => "key")));
		$form -> addElement(new Element_Hidden("sublogin", "sublogin"));
		$form -> addElement(new Element_Hidden("subredirect", $redirect));
		$form -> render();
	}

}
