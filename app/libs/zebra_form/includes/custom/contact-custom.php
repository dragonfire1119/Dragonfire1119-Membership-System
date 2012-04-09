<h2>A contact form</h2>

<p>Notice how the PHP code for the form remains basically unchanged, despite the template variations.<br>
The things that change, are the arguments passed to the <strong>render</strong> method, and the <em>width</em> of
some of the elements.</p>

<?php

    // include the Zebra_Form class
    require '../Zebra_Form.php';

    // instantiate a Zebra_Form object
    $form = new Zebra_Form('form');

    $form->client_side_validation(false);

    // the label for the "name" field
    $form->add('label', 'label_name', 'name', 'Your name:');

    // add the "name" field
    // the "&" symbol is there so that $obj will be a reference to the object in PHP 4
    // for PHP 5+ there is no need for it
    $obj = & $form->add('text', 'name', '', array('style' => 'width: 195px'));

    // set rules
    $obj->set_rule(array(

        // error messages will be sent to a variable called "error", usable in custom templates
        'required' => array('error', 'Name is required!')

    ));

    // "email"
    $form->add('label', 'label_email', 'email', 'Your email address:');

    $obj = & $form->add('text', 'email', '', array('style' => 'width: 195px'));

    $obj->set_rule(array(
        'required'  =>  array('error', 'Email is required!'),
        'email'     =>  array('error', 'Email address seems to be invalid!'),
    ));

    // "subject"
    $form->add('label', 'label_subject', 'subject', 'Subject');

    $obj = & $form->add('text', 'subject', '', array('style' => 'width:400px'));

    $obj->set_rule(array(
        'required' => array('error', 'Subject is required!')
    ));

    // "message"
    $form->add('label', 'label_message', 'message', 'Message:');

    $obj = & $form->add('textarea', 'message');

    $obj->set_rule(array(
        'required'  => array('error', 'Message is required!'),
        'length'    => array(0, 140, 'error', 'Maximum length is 140 characters!', true),
    ));

    // "submit"
    $form->add('submit', 'btnsubmit', 'Submit');

    // validate the form
    if ($form->validate()) {

        // do stuff here

    }

    // generate output using a custom template
    $form->render('includes/custom-templates/contact.php');

?>