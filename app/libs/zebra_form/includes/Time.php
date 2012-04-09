<?php

/**
 *  Class for time picker controls.
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @copyright  (c) 2006 - 2012 Stefan Gabos
 *  @package    Controls
 */
class Zebra_Form_Time extends Zebra_Form_Control
{

    /**
     *  Adds a time picker control to the form.
     *
     *  <b>Do not instantiate this class directly! Use the {@link Zebra_Form::add() add()} method instead!</b>
     *
     *  The output of this control will be one, two or three {@link Zebra_Form_Select select} controls for hour, minutes
     *  and seconds respectively, according to the given format as set by <i>$attributes</i>.
     *
     *  <code>
     *  //  create a new form
     *  $form = new Zebra_Form('my_form');
     *
     *  /**
     *   *  add a time picker control for hour and minutes
     *   *  the "&" symbol is there so that $obj will be a reference to the object in PHP 4
     *   *  for PHP 5+ there is no need for it
     *   {@*}
     *  $obj = &$form->add('time', 'my_time', date('H:i'), array('format' => 'hm'));
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
     *                                   *  for a control named "my_time", one would use:
     *                                   {@*}
     *                                  echo $my_time;
     *                                  </code>
     *
     *  @param  string  $default        (Optional) String representing the default time to be shown. Must be set according
     *                                  to the format of the time, as specified in <i>$attributes</i>. For example, for a
     *                                  time format of "hm", one would set the default time in the form of "hh:mm" while
     *                                  for a time format of "hms", one would set the time in the form of "hh:mm:ss".
     *
     *                                  Default is current system time.
     *
     *  @param  array   $attributes     (Optional) An array of user specified attributes valid for an time picker
     *                                  control (format, hours, minutes, seconds).
     *
     *                                  Must be specified as an associative array, in the form of <i>attribute => value</i>.
     *
     *                                  Available attributes are:
     *
     *                                  -   format - format of time; a string containing one of the three allowed
     *                                      characters "h" (hours), "m" (minutes) and "s" (seconds); (i.e. setting the
     *                                      format to "hm" would allow the selection of hours and minutes while setting the
     *                                      format to "hms" would allow the selection of hours, minutes and seconds)
     *
     *                                  -   hours - an array of selectable hours (i.e. array(10, 11, 12))
     *
     *                                  -   minutes - an array of selectable minutes (i.e. array(15, 30, 45))
     *
     *                                  -   seconds - an array of selectable seconds
     *
     *                                  See {@link Zebra_Form_Control::set_attributes() set_attributes()} on how to set
     *                                  attributes, other than through the constructor.
     *
     *  @return void
     */
    function Zebra_Form_Time($id, $default = '', $attributes = '')
    {
    
        // call the constructor of the parent class
        parent::Zebra_Form_Control();
    
        // these will hold the default selectable hours, minutes and seconds
        $hours = $minutes = $seconds = array();

        // all the 24 hours are available by default
        for ($i = 0; $i < 24; $i++) $hours[] = $i;

        // all the minutes and seconds are available by default
        for ($i = 0; $i < 60; $i++) $minutes[] = $seconds[] = $i;

        // set the private attributes of this control
        // these attributes are private for this control and are for internal use only
        // and will not be rendered by the _render_attributes() method
        $this->private_attributes = array(
        
            'disable_xss_filters',
            'locked',
            
        );

        // set the default attributes for the text control
        // put them in the order you'd like them rendered
        $this->set_attributes(
        
            array(
            
                'type'      =>  'time',
                'name'      =>  $id,
                'id'        =>  $id,
                'value'     =>  $default,
                'class'     =>  'control time',
                'format'    =>  'hm',
                'hours'     =>  $hours,
                'minutes'   =>  $minutes,
                'seconds'   =>  $seconds,

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

        // get some attributes of the control
        $attributes = $this->get_attributes(array('name', 'value', 'class', 'format', 'hours', 'minutes', 'seconds'));

        // see what have we sepcified as default time
        $time = array_diff(explode(':', $attributes['value']), array(''));

        // if, according to the time format, we have to show the hours and the hour is given in the default time
        // or a default time was not given (hence we turn to current system time)
        if (($hour_position = strpos($attributes['format'], 'h')) !== false && (isset($time[$hour_position]) || empty($time)))

            // the default selected hour
            $selected_hour = !empty($time) ? $time[0] : date('H');

        // if, according to the time format, we have to show the minutes and the minutes are given in the default time
        // or a default time was not given (hence we turn to current system time)
        if (($minutes_position = strpos($attributes['format'], 'm')) !== false && (isset($time[$minutes_position]) || empty($time)))

            // the default selected minute
            $selected_minute = !empty($time) ? $time[$minutes_position] : date('i');

        // if, according to the time format, we have to show the seconds and the seconds are given in the default time
        // or a default time was not given (hence we turn to current system time)
        if (($seconds_position = strpos($attributes['format'], 's')) !== false && (isset($time[$seconds_position]) || empty($time)))

            // the default selected minute
            $selected_second = !empty($time) ? $time[$seconds_position] : date('s');

        $output = '';

        // if the hour picker is to be shown
        if ($hour_position !== false) {

            // generate the hour picker
            $output .= '
                <select name="' . $attributes['name'] . '_hours" id="' . $attributes['name'] . '_hours" class="' . $attributes['class'] . '">';

            foreach ($attributes['hours'] as $hour)

                $output .= '<option value="' . $hour . '"' . (isset($selected_hour) && ltrim($selected_hour, '0') == ltrim($hour, '0') ? '  selected="selected"' : '') . '>' . str_pad($hour, 2, '0', STR_PAD_LEFT) . '</option>';

            $output .= '
                </select>
            ';

        }
        
        // if the minute picker is to be shown
        if ($minutes_position !== false) {

            // generate the minute picker
            $output .= '
                <select name="' . $attributes['name'] . '_minutes" id="' . $attributes['name'] . '_minutes" class="' . $attributes['class'] . '">';

            foreach ($attributes['minutes'] as $minute)

                $output .= '<option value="' . $minute . '"' . (isset($selected_minute) && ltrim($selected_minute, '0') == ltrim($minute, '0') ? ' selected="selected"' : '') . '>' . str_pad($minute, 2, '0', STR_PAD_LEFT) . '</option>';

            $output .= '
                </select>
            ';

        }

        // if the seconds picker is to be shown
        if ($seconds_position !== false) {

            // generate the seconds picker
            $output .= '
                <select name="' . $attributes['name'] . '_seconds" id="' . $attributes['name'] . '_seconds" class="' . $attributes['class'] . '">';

            foreach ($attributes['seconds'] as $second)

                $output .= '<option value="' . $second . '"' . (isset($selected_second) && ltrim($selected_second, '0') == ltrim($second, '0') ? ' selected="selected"' : '') . '>' . str_pad($second, 2, '0', STR_PAD_LEFT) . '</option>';

            $output .= '
                </select>
            ';

        }

        $output .= '<div class="clear"></div>';

        return $output;

    }

}

?>
