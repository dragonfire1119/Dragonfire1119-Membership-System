<?php

/**
 *  Class for checkbox controls.
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @copyright  (c) 2006 - 2012 Stefan Gabos
 *  @package    Controls
 */
class Zebra_Form_Checkbox extends Zebra_Form_Control
{

    /**
     *  Adds an <input type="checkbox"> control to the form.
     *
     *  <b>Do not instantiate this class directly! Use the {@link Zebra_Form::add() add()} method instead!</b>
     *
     *  <code>
     *  // create a new form
     *  $form = new Zebra_Form('my_form');
     *
     *  /**
     *   *  single checkbox
     *   *  the "&" symbol is there so that $obj will be a reference to the object in PHP 4
     *   *  for PHP 5+ there is no need for it
     *   {@*}
     *  $obj = &$form->add('checkbox', 'my_checkbox', 'my_checkbox_value');
     *
     *  /**
     *   *  multiple checkboxes
     *   *  notice that is "checkboxes" instead of "checkbox"
     *   *  label controls will be automatically created having the names "more_checkboxes_value_1",
     *   *  "more_checkboxes_value_2" and so on
     *   *  $obj is a reference to the first checkbox
     *   *  checkboxes values will be "0", "1" and "2", respectively
     *   {@*}
     *  $obj = &$form->add('checkboxes', 'more_checkboxes',
     *      array(
     *          'Value 1',
     *          'Value 2',
     *          'Value 3'
     *      )
     *  );
     *
     *  /**
     *   *  multiple checkboxes with specific indexes
     *   *  checkboxes values will be "v1", "v2" and "v3", respectively
     *   *  label controls will be automatically created having the names "some_more_checkboxes_value_1",
     *   *  "some_more_checkboxes_value_2" and so on
     *   {@*}
     *  $obj = &$form->add('checkboxes', 'some_more_checkboxes',
     *      array(
     *          'v1' => 'Value 1',
     *          'v2' => 'Value 2',
     *          'v3' => 'Value 3'
     *      )
     *  );
     *
     *  /**
     *   *  multiple checkboxes with preselected value
     *   *  "Value 2" will be the preselected value
     *   *  note that for preselecting values you must use the actual indexes of the values, if available, (like
     *   *  in the current example) or the default, zero-based index, otherwise (like in the next example)
     *   *  label controls will be automatically created having the names "and_some_more_checkboxes_value_v1",
     *   *  "and_some_more_checkboxes_value_v2" and so on
     *   {@*}
     *  $obj = &$form->add('checkboxes', 'and_some_more_checkboxes',
     *      array(
     *          'v1'    =>  'Value 1',
     *          'v2'    =>  'Value 2',
     *          'v3'    =>  'Value 3'
     *      ),
     *      'v2'    //  note the index!
     *  );
     *
     *  /**
     *   *  "Value 2" will be the preselected value.
     *   *  note that for preselecting values you must use the actual indexes of the values, if available, (like
     *   *  in the example above) or the default, zero-based index, otherwise (like in the current example)
     *   *  label controls will be automatically created having the names "and_some_more_checkboxes_value_0",
     *   *  "and_some_more_checkboxes_value_1" and so on
     *   {@*}
     *  $obj = &$form->add('checkboxes', 'and_some_more_checkboxes',
     *      array(
     *          'Value 1',
     *          'Value 2',
     *          'Value 3'
     *      ),
     *      1    //  note the index!
     *  );
     *
     *  /**
     *   *  multiple checkboxes with multiple preselected values
     *   {@*}
     *  $obj = &$form->add('checkboxes', 'other_checkboxes[]',
     *      array(
     *          'v1'    =>  'Value 1',
     *          'v2'    =>  'Value 2',
     *          'v3'    =>  'Value 3'
     *      ),
     *      array('v1', 'v2')
     *  );
     *
     *  // don't forget to always call this method before rendering the form
     *  if ($form->validate()) {
     *      // put code here
     *  }
     *
     *  // output the form using an automatically generated template
     *  $form->render();
     *  </code>
     *
     *  @param  string  $id             Unique name to identify the control in the form.
     *
     *                                  <b>$id needs to be suffixed with square brackets if there are more checkboxes
     *                                  sharing the same name, so that PHP treats them as an array!</b>
     *
     *                                  The control's <b>name</b> attribute will be as indicated by <i>$id</i>
     *                                  argument while the control's <b>id</b> attribute will be <i>$id</i>, stripped of
     *                                  square brackets (if any), followed by an underscore and followed by <i>$value</i>
     *                                  with all the spaces replaced by <i>underscores</i>.
     *
     *                                  So, if the <i>$id</i> arguments is "my_checkbox" and the <i>$value</i> argument
     *                                  is "value 1", the control's <b>id</b> attribute will be <b>my_checkbox_value_1</b>.
     *
     *                                  This is the name to be used when referring to the control's value in the
     *                                  POST/GET superglobals, after the form was submitted.
     *
     *                                  This is also the name of the variable to be used in the template file, containing
     *                                  the generated HTML for the control.
     *
     *                                  <code>
     *                                  /**
     *                                   *  in a template file, in order to print the generated HTML
     *                                   *  for a control named "my_checkbox" and having the value of "value 1",
     *                                   *  one would use:
     *                                   {@*}
     *                                  echo $my_checkbox_value_1;
     *                                  </code>
     *
     *                                  <i>Note that when adding the required rule to a group of checkboxes (checkboxes
     *                                  sharing the same name), it is sufficient to add the rule to the first checkbox!</i>
     *
     *  @param  mixed   $value          Value of the checkbox.
     *
     *  @param  array   $attributes     (Optional) An array of attributes valid for
     *                                  {@link http://www.w3.org/TR/REC-html40/interact/forms.html#h-17.4 input}
     *                                  controls (disabled, readonly, style, etc)
     *
     *                                  Must be specified as an associative array, in the form of <i>attribute => value</i>.
     *                                  <code>
     *                                  //  setting the "checked" attribute
     *                                  $obj = &$form->add(
     *                                      'checkbox',
     *                                      'my_checkbox',
     *                                      'v1',
     *                                      array(
     *                                          'checked' => 'checked'
     *                                      )
     *                                  );
     *                                  </code>
     *
     *                                  See {@link Zebra_Form_Control::set_attributes() set_attributes()} on how to set
     *                                  attributes, other than through the constructor.
     *
     *                                  The following attributes are automatically set when the control is created and
     *                                  should not be altered manually:<br>
     *
     *                                  <b>type</b>, <b>id</b>, <b>name</b>, <b>value</b>, <b>class</b>
     *
     *  @return void
     */
    function Zebra_Form_Checkbox($id, $value, $attributes = '')
    {
    
        // call the constructor of the parent class
        parent::Zebra_Form_Control();
    
        // set the private attributes of this control
        // these attributes are private for this control and are for internal use only
        // and will not be rendered by the _render_attributes() method
        $this->private_attributes = array(

            'disable_xss_filters',
            'locked',

        );

        // set the default attributes for the checkbox control
        // put them in the order you'd like them rendered
        $this->set_attributes(
        
            array(
            
                'type'  =>  'checkbox',
                'name'  =>  $id,
                'id'    =>  str_replace(array(' ', '[', ']'), array('_', ''), $id) . '_' . str_replace(' ', '_', $value),
                'value' =>  $value,
                'class' =>  'control checkbox',

            )
            
        );
        
        // sets user specified attributes for the control
        $this->set_attributes($attributes);
        
    }
    
    /**
     *  Returns the generated HTML code for the control.
     *
     *  <i>This method is automatically called by the {@link Zebra_Form::render() render()} method!</i>
     *
     *  @return string  The generated HTML code for the control
     */
    function toHTML()
    {
    
        return '<input ' . $this->_render_attributes() . ($this->form_properties['doctype'] == 'xhtml' ? '/' : '') . '>';

    }

}

?>
