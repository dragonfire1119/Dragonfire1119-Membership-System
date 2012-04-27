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
 
if (!defined("DMS")) {
	die("You can't access this");
}

$options = array("Remember Me?");
$form = new Form("validation", 400);
$form -> addElement(new Element_Hidden("form", "validation"));
$form -> addElement(new Element_Textbox("Email:", "email", array("validation" => new Validation_Required)));
$form -> addElement(new Element_Password("Password:", "password", array("validation" => new Validation_Required)));
$form -> addElement(new Element_Checkbox("", "remember", $options));
$form -> addElement(new Element_Button("Login", "submit", array("icon" => "key")));
$form -> addElement(new Element_Hidden("sublogin", "sublogin"));
$form -> render();