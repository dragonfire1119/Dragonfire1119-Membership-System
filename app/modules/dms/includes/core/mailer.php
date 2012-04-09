<?php 
/* Dragonfire1119 Membership Script Beta 0.2
 * Copyright (c) 2011 Christopher Hicks
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: December 11, 2011
 *------------------------------------------------------------------------------------------------*/

if (!defined('DMS_SECURITY')) {
    die('Hacking attempt...');
}

class Mailer
{
   /**
    * sendWelcome - Sends a welcome message to the newly
    * registered user, also supplying the username and
    * password.
    */
   function sendWelcome($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = mailer_suject;
      $body = $user.",\n\n"
             . mailer_welcome
             ."with the following information:\n\n"
             ."Username: ".$user."\n"
             ."Password: ".$pass."\n\n"
             ."If you ever lose or forget your password, a new "
             ."password will be generated for you and sent to this "
             ."email address, if you would like to change your "
             ."email address you can do so by going to the "
             ."My Account page after signing in.\n\n"
             .mailer_name;

      return mail($email,$subject,$body,$from);
   }
   
   /*
    * sendActivation
    */
   function sendActivation($user, $email, $pass){
       $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
       $subject = mailer_suject;
       $body = $user.",\n\n"
               . mailer_welcome
               ."Hi $user,"
               ."Complete this step to activate your login identity at " 
               .dyn_www
               ." Click the line below to activate when ready "
               ."http://"
               .dyn_www
               ."/activation.php?user=$user"
               ." If the URL above is not an active link, please copy and paste it into your browser address bar "
               ."Login after successful activation using your: "
               ."E-mail Address: $email1"
               ."Password: $pass1"
               ."See you on the site!"
               .mailer_name;
       
       return mail($email,$subject,$body,$from);
   }
   
   /**
    * sendNewPass - Sends the newly generated password
    * to the user's email address that was specified at
    * sign-up.
    */
   function sendNewPass($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = mailer_suject;
      $body = $user.",\n\n"
             ."We've generated a new password for you at your "
             ."request, you can use this new password with your "
             ."username to log in to" .site_name. " Site.\n\n"
             ."Username: ".$user."\n"
             ."New Password: ".$pass."\n\n"
             ."It is recommended that you change your password "
             ."to something that is easier to remember, which "
             ."can be done by going to the My Account page "
             ."after signing in.\n\n"
             .mailer_name;
             
      return mail($email,$subject,$body,$from);
   }
};

/* Initialize mailer object */
$mailer = new Mailer;
 
?>