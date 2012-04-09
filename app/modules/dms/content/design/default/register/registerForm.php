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