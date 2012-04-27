<?php
if (!defined("DMS")) {
	die("You can't access this");
}

$options = array("Remember Me?");
$form = new Form("validation", 400);
$form -> addElement(new Element_Hidden("form", "validation"));
$form -> addElement(new Element_Hidden("from", $this->data['email'], array("value" => $this->data['email'])));
$form -> addElement(new Element_Textbox("To", "to"));
$form -> addElement(new Element_Textarea("Message", "message"));
$form -> addElement(new Element_Button("Send", "subsend", array("icon" => "key")));
$form -> render();
