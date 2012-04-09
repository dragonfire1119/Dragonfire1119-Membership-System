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
?>
<?php
$options = array(captchacheckboxmessage);
$form = new Form("elements", 400, "process.php");
$form->configure(array(
    "view" => new View_Grid(array(1, 2, 1, 2))
));
$form -> addElement(new Element_Hidden("form", "elements"));
$form -> addElement(new Element_Textbox(username, "user"));
$form -> addElement(new Element_Password(password, "pass"));
$form -> addElement(new Element_Password(passwordconfirm, "passconfirm"));
$form -> addElement(new Element_Date(dateofbirth, "dateofbirth", array(
    "value" => "00/00/0000"
)));
$form -> addElement(new Element_Email(email, "email"));
$form -> addElement(new Element_Email(emailconfirm, "emailconfirm"));
if (captcha == 'check_box') {
	$form -> addElement(new Element_Checkbox("", "captcha", $options));
} else if (captcha == 'reCAPTCHA') {
	$form -> addElement(new Element_Captcha("Captcha:"));
} else {
	$form -> addElement(new Element_Hidden("honeypot", ""));
}
$form -> addElement(new Element_Hidden("subjoin", ""));
$form->addElement(new Element_Button);
$form -> render();
?>