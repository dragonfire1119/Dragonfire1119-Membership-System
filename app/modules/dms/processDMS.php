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

class ProcessDMS {
    /* Class constructor */

    function ProcessDMS() {
        global $session;
        /* User submitted login form */
        if (isset($_POST['sublogin'])) {
            $this->procLogin();
        }
        /* User submitted registration form */ else if (isset($_POST['subjoin'])) {
            $this->procRegister();
        }
        /* User submitted forgot password form */ else if (isset($_POST['subforgot'])) {
            $this->procForgotPass();
        }
        /* User submitted edit account form */ else if (isset($_POST['subedit'])) {
            $this->procEditAccount();
		} else if (isset($_POST['submessage'])) {
			$this->procsendmessage();
        } else if (isset($_POST['subavatar'])) {
            $this->procAvatar();
        } else if (isset($_POST['submitpm'])) {
            $this->procPM();
        }
        /**
         * The only other reason user should be directed here
         * is if he wants to logout, which means user is
         * logged in currently.
         */ else if ($session->logged_in) {
            $this->procLogout();
        }
        /**
         * Should not get here, which means user is viewing this page
         * by mistake and therefore is redirected.
         */ else {
            header("Location: index.php");
        }
    }

    /**
     * procLogin - Processes the user submitted login form, if errors
     * are found, the user is redirected to correct the information,
     * if not, the user is effectively logged in to the system.
     */
    function procLogin() {
        global $session, $dmsForm;
        /* Login attempt */
        $retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));
		
		if (empty($_POST['subredirect'])) {
			$this->redirect = $session->referrer;
		} else {
			$this->redirect = $_POST['subredirect'];
		}

        /* Login successful */
        if ($retval) {
            header("Location: " . $session->referrer);
        }
        /* Login failed */ else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: " . $this->redirect);
        }
    }

    /**
     * procLogout - Simply attempts to log the user out of the system
     * given that there is no logout form to process.
     */
    function procLogout() {
        global $session;
        $retval = $session->logout();
        header("Location: index.php");
    }

    /**
     * procRegister - Processes the user submitted registration form,
     * if errors are found, the user is redirected to correct the
     * information, if not, the user is effectively registered with
     * the system and an email is (optionally) sent to the newly
     * created user.
     */
    function procRegister() {
        global $session, $dmsForm;
        /* Convert username to all lowercase (by option) */
        if (ALL_LOWERCASE) {
            $_POST['user'] = strtolower($_POST['user']);
        }
        /* Registration attempt */
        $retval = $session->register($_POST['user'], $_POST['pass'], $_POST['passconfirm'], $_POST['birth_day'], $_POST['birth_month'], $_POST['birth_year'], $_POST['email'], $_POST['emailconfirm'], $_POST['captcha_code'], $_POST['captcha'], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

        /* Registration Successful */
        if ($retval == 0) {
            $_SESSION['reguname'] = $_POST['user'];
            $_SESSION['regsuccess'] = true;
            // This only works if you have it going to register.php or another page
            header("Location: " . $session->referrer);
            //header("Location: index.php?register=true");
        }
        /* Error found with form */ else if ($retval == 1) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            // This only works if you have it going to register.php or another page
            header("Location: " . $session->referrer);
            //header("Location: index.php?register=1");
        }
        /* Registration attempt failed */ else if ($retval == 2) {
            $_SESSION['reguname'] = $_POST['user'];
            $_SESSION['regsuccess'] = false;
            // This only works if you have it going to register.php or another page
            header("Location: " . $session->referrer);
            //header("Location: index.php?register=2");
        }
    }

	private function procsendmessage() {
		
		/* PM Successful */
        if ($retval == 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: messages");
        }
        /* Error found with form */ else if ($retval == 1) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: messages");
        }
        /* PM attempt failed */ else if ($retval == 2) {
            $_SESSION['reguname'] = $_POST['to_user'];
            $_SESSION['regsuccess'] = false;
            header("Location: messages");
        }
	}

    /*
     * PM
     */

    function procPM() {
        global $session, $dmsForm;
        /* PM attempt */
        $retval = $session->insertpm($_POST['to_user'], $_POST['from_user'], $_POST['subject'], $_POST['message']);

        /* PM Successful */
        if ($retval == 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: index.php?go=sendpm");
        }
        /* Error found with form */ else if ($retval == 1) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: index.php?go=sendpm");
        }
        /* PM attempt failed */ else if ($retval == 2) {
            $_SESSION['reguname'] = $_POST['to_user'];
            $_SESSION['regsuccess'] = false;
            header("Location: index.php?go=sendpm");
        }
    }

    /**
     * procForgotPass - Validates the given username then if
     * everything is fine, a new password is generated and
     * emailed to the address the user gave on sign up.
     */
    function procForgotPass() {
        global $database, $session, $mailer, $dmsForm;
        /* Username error checking */
        $subuser = $_POST['user'];
        $field = "user";  //Use field name for username
        if (!$subuser || strlen($subuser = trim($subuser)) == 0) {
            $form->setError($field, "* Username not entered<br>");
        } else {
            /* Make sure username is in database */
            $subuser = stripslashes($subuser);
            if (strlen($subuser) < 5 || strlen($subuser) > 30 ||
                    !eregi("^([0-9a-z])+$", $subuser) ||
                    (!$database->usernameTaken($subuser))) {
                $dmsForm->setError($field, "* Username does not exist<br>");
            }
        }

        /* Errors exist, have user correct them */
        if ($dmsForm->num_errors > 0) {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
        }
        /* Generate new password and email it to user */ else {
            /* Generate new password */
            $newpass = $session->generateRandStr(8);

            /* Get email of user */
            $usrinf = $database->getUserInfo($subuser);
            $email = $usrinf['email'];

            /* Attempt to send the email with new password */
            if ($mailer->sendNewPass($subuser, $email, $newpass)) {
                /* Email sent, update database */
                $database->updateUserField($subuser, "password", md5($newpass));
                $_SESSION['forgotpass'] = true;
            }
            /* Email failure, do not change password */ else {
                $_SESSION['forgotpass'] = false;
            }
        }

        header("Location: " . $session->referrer);
    }

    /**
     * procEditAccount - Attempts to edit the user's account
     * information, including the password, which must be verified
     * before a change is made.
     */
    function procEditAccount() {
        global $session, $dmsForm;

        /* Account edit attempt */
        $retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email'], $_POST['bio'], $_POST['profile_status']);

        /* Account edit successful */
        if ($retval) {
            $_SESSION['useredit'] = true;
            header("Location: " . $session->referrer);
        }
        /* Error found with form */ else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: " . $session->referrer);
        }
    }

    function procAvatar() {
        global $session, $dmsForm;

        /* Account edit attempt */
        $retval = $session->avatarupload($_FILES['fileField']['tmp_name'], $_FILES['fileField']['name'], $_FILES['fileField']['size']);

        /* Account edit successful */
        if ($retval) {
            $_SESSION['useravatar'] = true;
            header("Location: ucp.php?act=avatarupload");
        }
        /* Error found with form */ else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $dmsForm->getErrorArray();
            header("Location: ucp.php?act=avatarupload");
        }
    }

}

;
/* Initialize process */
$processDMS = new ProcessDMS;
?>