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

$options = array("Check this if your a human");
$form = new Form("validation", 400);
$form -> configure(array("view" => new View_Grid( array(1, 1, 2, 1, 1))));
$form -> addElement(new Element_Hidden("form", "validation"));
$form -> addElement(new Element_Textbox("Your current email address", "email", array("validation" => array(new Validation_Required, new Validation_Email))));
$form -> addElement(new Element_Textbox("Username", "username", array("validation" => new Validation_Required)));
$form -> addElement(new Element_Password("Password", "password", array("validation" => new Validation_Required)));
$form -> addElement(new Element_Password("Confirm Password", "passconfirm", array("validation" => new Validation_Required)));
$form -> addElement(new Element_Email("You Gravatar", "gravatar", array("validation" => array(new Validation_Required, new Validation_Email))));
$form -> addElement(new Element_Date("Birthday", "dateofbirth", array("validation" => array(new Validation_Required, new Validation_Date), "description" => "Example: 00/00/0000")));
if (captcha == 'check_box') {
	$form -> addElement(new Element_Checkbox("", "captcha", $options, array("validation" => new Validation_Required)));
} else if (captcha == 'reCAPTCHA') {
	$form -> addElement(new Element_Captcha("Captcha:", "Captcha", array("validation" => new Validation_Required)));
} else {
	$form -> addElement(new Element_Hidden("honeypot", ""));
}
$form -> addElement(new Element_Hidden("subjoin2", ""));
$form -> addElement(new Element_Button);
$form -> render();
