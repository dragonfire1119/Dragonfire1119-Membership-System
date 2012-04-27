<?php
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