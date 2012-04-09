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

include_once("security.php");
echo $security->idefined();

class dmsForm
{
   var $values = array();  //Holds submitted form field values
   var $errors = array();  //Holds submitted form error messages
   var $num_errors;   //The number of errors in submitted form

   /* Class constructor */
   function dmsForm(){
      /**
       * Get form value and error arrays, used when there
       * is an error with a user-submitted form.
       */
      if(isset($_SESSION['value_array']) && isset($_SESSION['error_array'])){
         $this->values = $_SESSION['value_array'];
         $this->errors = $_SESSION['error_array'];
         $this->num_errors = count($this->errors);

         unset($_SESSION['value_array']);
         unset($_SESSION['error_array']);
      }
      else{
         $this->num_errors = 0;
      }
   }

   /**
    * setValue - Records the value typed into the given
    * form field by the user.
    */
   function setValue($field, $value){
      $this->values[$field] = $value;
   }

   /**
    * setError - Records new form error given the form
    * field name and the error message attached to it.
    */
   function setError($field, $errmsg){
      $this->errors[$field] = $errmsg;
      $this->num_errors = count($this->errors);
   }

   /**
    * value - Returns the value attached to the given
    * field, if none exists, the empty string is returned.
    */
   function value($field){
      if(array_key_exists($field,$this->values)){
         return htmlspecialchars(stripslashes($this->values[$field]));
      }else{
         return "";
      }
   }

   /**
    * error - Returns the error message attached to the
    * given field, if none exists, the empty string is returned.
    */
   function error($field){
      if(array_key_exists($field,$this->errors)){
         return "<font size=\"2\" color=\"#ff0000\">".$this->errors[$field]."</font>";
         /*return '<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Error: <a href="">'.$this->errors[$field].'</a></td>
					<td class="red-right"><a class="close-red"><img src="app/views/index/images/table/icon_close_red.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';*/
          /*return '<div class="error-left"></div>
			<div class="error-inner">'.$this->errors[$field].'</div>';*/
      }else{
         return "";
      }
   }
   
   /**
    * error - Returns the success message attached to the
    * given field, if none exists, the empty string is returned.
    */
   function success($field){
      if(array_key_exists($field,$this->errors)){
         return "<font size=\"2\" color=\"#009900\">".$this->errors[$field]."</font>";
         /*return '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">'.$this->errors[$field].'</td>
					<td class="green-right"><a class="close-green"><img src="app/views/index/images/table/icon_close_green.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';*/
      }else{
         return "";
      }
   }

   /* getErrorArray - Returns the array of error messages */
   function getErrorArray(){
      return $this->errors;
   }
};
 
?>