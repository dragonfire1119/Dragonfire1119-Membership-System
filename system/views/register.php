<?php
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
