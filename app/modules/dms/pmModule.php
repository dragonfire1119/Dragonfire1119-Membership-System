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

class pmModule {

	function __construct() {

	}

	public function render($type, $username=NULL) {

		switch ($type) {
			case "messagesender" :
				$this -> messageSender($username);
				break;
			case "messagereader" :
				break;
			default :
				die("You have to pick what type over module you want in $pm->render();");
		}
	}

	private function messageSender($username=NULL) {
		global $form;

		$options = array("Remember Me?");
		$form = new Form("layout_standard", 300, "process.php");
		$form -> addElement(new Element_Hidden("form", "layout_standard"));
		$form -> addElement(new Element_Hidden("from", "{$username}"));
		$form -> addElement(new Element_Textbox("To:", "to"));
		$form -> addElement(new Element_Textarea("Message:", "message"));
		$form -> addElement(new Element_Hidden("submessage", "submessage"));
		$form -> addElement(new Element_Button);
		$form -> render();
	}

}

$pm = new pmModule;
?>