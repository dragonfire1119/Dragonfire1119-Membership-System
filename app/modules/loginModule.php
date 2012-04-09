<?php

/**
 *
 */
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
