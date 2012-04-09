<?php

/**
 *  Class for date controls.
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @copyright  (c) 2006 - 2012 Stefan Gabos
 *  @package    Controls
 */
class Zebra_Form_Date extends Zebra_Form_Control
{

    /**
     *  Adds a date control to the form.
     *
     *  <b>Do not instantiate this class directly! Use the {@link Zebra_Form::add() add()} method instead!</b>
     *
     *  The output of this control will be a {@link Zebra_Form_Text textbox} control with an icon to the right of it.<br>
     *  Clicking the icon will open an inline JavaScript date picker.<br>
     *
     *  <code>
     *  //  create a new form
     *  $form = new Zebra_Form('my_form');
     *
     *  /**
     *   *  add a date control to the form
     *   *  the "&" symbol is there so that $obj will be a reference to the object in PHP 4
     *   *  for PHP 5+ there is no need for it
     *   {@*}
     *  $obj = &$form->add('date', 'my_date', date('Y-m-d'));
     *
     *  //  set the date's format
     *  $obj->format('Y-m-d');
     *
     *  // don't forget to always call this method before rendering the form
     *  if ($form->validate()) {
     *      // put code here
     *  }
     *
     *  //  output the form using an automatically generated template
     *  $form->render();
     *  </code>
     *
     *  @param  string  $id             Unique name to identify the control in the form.
     *
     *                                  The control's <b>name</b> attribute will be the same as the <b>id</b> attribute!
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
     *                                   *  for a control named "my_date", one would use:
     *                                   {@*}
     *                                  echo $my_date;
     *                                  </code>
     *
     *  @param  string  $default        (Optional) Default date, formatted according to {@link format() format}.
     *
     *  @param  array   $attributes     (Optional) An array of attributes valid for
     *                                  {@link http://www.w3.org/TR/REC-html40/interact/forms.html#h-17.4 input}
     *                                  controls (size, readonly, style, etc)
     *
     *                                  Must be specified as an associative array, in the form of <i>attribute => value</i>.
     *                                  <code>
     *                                  //  setting the "readonly" attribute
     *                                  $obj = &$form->add(
     *                                      'date',
     *                                      'my_date',
     *                                      '',
     *                                      array(
     *                                          'readonly' => 'readonly'
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
    function Zebra_Form_Date($id, $default = '', $attributes = '')
    {
    
        // call the constructor of the parent class
        parent::Zebra_Form_Control();
    
        // set the private attributes of this control
        // these attributes are private for this control and are for internal use only
        // and will not be rendered by the _render_attributes() method
        $this->private_attributes = array(
        
            'locked',
            'disable_xss_filters',
            'date',
            
        );

        // set the javascript attributes of this control
        // these attributes will be used by the JavaScript date picker object
        $this->javascript_attributes = array(

            'days',
            'direction',
            'disabled_dates',
            'first_day_of_the_week',
            'format',
            'months',
            'offset',
            'readonly_element',
            'view',
            'weekend_days',

        );

        // set the default attributes for the text control
        // put them in the order you'd like them rendered
        $this->set_attributes(
        
            array(
            
                'type'                  =>  'text',
                'name'                  =>  $id,
                'id'                    =>  $id,
                'value'                 =>  $default,
                'class'                 =>  'control text date',

                'days'                  =>  null,
                'direction'             =>  null,
                'disabled_dates'        =>  null,
                'first_day_of_the_week' =>  null,
                'format'                =>  'Y-m-d',
                'months'                =>  null,
                'offset'                =>  null,
                'readonly_element'      =>  null,
                'view'                  =>  null,
                'weekend_days'          =>  null,

            )
            
        );
        
        // sets user specified attributes for the control
        $this->set_attributes($attributes);
        
    }

    /**
     *  Direction of the calendar.
     *
     *  @param  mixed   $direction      A positive or negative integer:
     *
     *                                  -   n (a positive integer) creates a future-only calendar beginning at n days
     *                                      after today;
     *
     *                                  -   -n (a negative integer) creates a past-only calendar ending at n days
     *                                      before today;
     *
     *                                  -   if n is 0, the calendar has no restrictions.
     *
     *                                  Use boolean TRUE for a future-only calendar starting with today and use boolean
     *                                  FALSE for a past-only calendar ending today.
     *
     *                                  Default is 0 (no restrictions).
     *
     *  @return void
     */
    function direction($direction)
    {

        // set the date picker's attribute
        $this->set_attributes(array('direction' => $direction));

    }

    /**
     *  Disables selection of specific dates or range of dates in the calendar.
     *
     *  @param  array   $disabled_dates     An array of strings representing disabled dates. Values in the string have
     *                                      to be in the following format: "day month year weekday" where "weekday" is
     *                                      optional and can be 0-6 (Saturday to Sunday); The syntax is similar to
     *                                      cron's syntax: the values are separated by spaces and may contain * (asterisk)
     *                                      -&nbsp;(dash) and , (comma) delimiters:
     *
     *                                      array('1 1 2012') would disable January 1, 2012;
     *
     *                                      array('* 1 2012') would disable all days in January 2012;
     *
     *                                      array('1-10 1 2012') would disable January 1 through 10 in 2012;
     *
     *                                      array('1,10 1 2012') would disable January 1 and 10 in 2012;
     *
     *                                      array('1-10,20,22,24 1-3 *') would disable 1 through 10, plus the 22nd and
     *                                      24th of January through March for every year;
     *
     *                                      array('* * * 0,6') would disable all Saturdays and Sundays;
     *
     *                                      Default is FALSE, no disabled dates.
     *
     *  @return void
     */
    function disabled_dates($disabled_dates) {

        // set the date picker's attribute
        $this->set_attributes(array('disabled_dates' => $disabled_dates));

    }

    /**
     *  Week's starting day.
     *
     *  @param  integer $day    Valid values are 0 to 6, Sunday to Saturday.
     *
     *                          Default is 1, Monday.
     *
     *  @return void
     */
    function first_day_of_the_week($day)
    {

        // set the date picker's attribute
        $this->set_attributes(array('first_day_of_the_week' => $day));

    }

    /**
     *  Sets the format of the returned date.
     *
     *  @param  string  $format     Format of the returned date.
     *
     *                              Accepts the following characters for date formatting: d, D, j, l, N, w, S, F, m, M,
     *                              n, Y, y borrowing syntax from ({@link http://www.php.net/manual/en/function.date.php PHP's date function})
     *
     *                              Default format is <b>Y-m-d</b>
     *
     *  @return void
     */
    function format($format) {

        // set the date picker's attribute
        $this->set_attributes(array('format' => $format));

    }

    /**
     *  <b>To be used after the form was submitted!</b>
     *
     *  Returns submitted date in the YYYY-MM-DD format so that it's directly usable with a database engine or with
     *  PHP's {@link http://php.net/manual/en/function.strtotime.php strtotime} function.
     *
     *  @return string  Returns submitted date in the YYYY-MM-DD format.
     */
    function get_date()
    {

        $result = $this->get_attributes('date');

        // if control had a value return it, or return an empty string otherwise
        return (isset($result['date'])) ? $result['date'] : '';

    }

    /**
     *  Sets wether the element the calendar is attached to should be read-only.
     *
     *  @param  boolean $value      The setting's value
     *
     *                              If set to TRUE, a date can be set only through the date picker and cannot be enetered
     *                              manually.
     *
     *                              Default is TRUE.
     *
     *  @return void
     */
    function readonly_element($value) {

        // set the date picker's attribute
        $this->set_attributes(array('readonly_element' => $value));

    }

    /**
     *  Sets how should the date picker start.
     *
     *  @param  string  $view       How should the date picker start.
     *
     *                              Valid values are "days", "months" and "years".
     *
     *                              Default is "days".
     *
     *  @return void
     */
    function view($view) {

        // set the date picker's attribute
        $this->set_attributes(array('view' => $view));

    }

    /**
     *  Sets the days of the week that are to be considered  as "weekend days".
     *
     *  @param  array   $days       An array of days of the week that are to be considered  as "weekend days".
     *
     *                              Valid values are 0 to 6, Sunday to Saturday.
     *
     *                              Default is array(0,6) (Saturday and Sunday).
     *
     *  @return void
     */
    function weekend_days($days) {

        // set the date picker's attribute
        $this->set_attributes(array('view' => $view));

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

        // get some attributes of the control
        $attributes = $this->get_attributes(array('name'));
        
        return '
            <div>
                <input ' . $this->_render_attributes() . ($this->form_properties['doctype'] == 'xhtml' ? '/' : '') . '>
                <div class="clear"></div>
            </div>
        ';

    }

}

?>
