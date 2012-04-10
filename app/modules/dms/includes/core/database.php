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

if (!defined('DMS_SECURITY')) {
	die('Hacking attempt...');
}

class mysqlDB {

	var $connect;
	var $connection;
	//The mysql database connection
	var $connectioni;
	var $num_active_users;
	//Number of active users viewing site
	var $num_active_guests;
	//Number of active guests viewing site
	var $num_members;
	//Number of signed-up users
	var $host;
	var $db;
	var $user;
	var $pass;
	var $db_type;

	/* Note: call getNumMembers() to access $num_members! */

	/* Class constructor */

	function mysqlDB() {
		/* Make connection to database */
		$this -> connect = R::setup('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . '', '' . DB_USER . '', '' . DB_PASSS . '');

		/**
		 * Only query database to find out number of members
		 * when getNumMembers() is called for the first time,
		 * until then, default value set.
		 */
		$this -> num_members = -1;

		if (TRACK_VISITORS) {
			/* Calculate number of users at site */
			$this -> calcNumActiveUsers();

			/* Calculate number of guests at site */
			$this -> calcNumActiveGuests();
		}
	}

	/*
	 * Updates the options
	 */

	function addconfig($sitename, $siteurl, $timezone, $timeformat, $captcha, $public_key, $private_key, $theme_name, $track_visitors, $cookieexpire, $cookiepath, $emailfromname, $emailfromaddress, $emailwelcome) {
		$this -> connect;
		$sth = R::exec("UPDATE " . TBL_CONFIG . " SET `config_value` = CASE `config_name`
WHEN 'site_name' THEN '$sitename'
WHEN 'site_url' THEN '$siteurl'
WHEN 'time_zone' THEN '$timezone'
WHEN 'time_format' THEN '$timeformat'
WHEN 'captcha' THEN '$captcha'
WHEN 'public_key' THEN '$public_key'
WHEN 'private_key' THEN '$private_key'
WHEN 'theme_name' THEN '$theme_name'
WHEN 'track_visitors' THEN '$track_visitors'
WHEN 'cookie_expire' THEN '$cookieexpire'
WHEN 'cookie_path' THEN '$cookiepath'
WHEN 'email_from_name' THEN '$emailfromname'
WHEN 'email_from_address' THEN '$emailfromaddress'
WHEN 'email_welcome' THEN '$emailwelcome'
ELSE `config_value`
END");
		$result = $sth;
		if (!$result) {
			return 1;
			//Indicates config failure
		}
	}

	/*
	 * This is the key to activating the user when he goes to index.php?activation=theidea
	 */

	function activation($user) {
		$this -> connect;
		$sql = "UPDATE users SET email_activated='1' WHERE username='$user'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		/* Error occurred, return given name by default */
		$num_rows = count($rows);

		$sql_doublecheck = "SELECT * FROM users WHERE username='$user' AND email_activated='1'";
		$stmt = R::getRow($sql_doublecheck);
		$rows = $stmt;
		$doublecheck = count($rows);
		if ($doublecheck == 0) {
			echo "<br /><br /><h3><strong><font color=red>Your account could not be activated!</font></strong><h3><br />
        <br />
        Please email site administrator and request manual activation.
        echo POWERED_BY
        ";
			exit();
		} elseif ($doublecheck > 0) {

			echo '<br /><br /><h3><font color=\"#0066CC\"><strong>Your account has been activated! <br /><br />
        <a href="index.php">Go to Main</a></strong></font></h3>';

			exit();
		}
	}

	// This is the action to delete a pm out of the inbox
	function deleteinboxpm($to_user, $id) {
		global $session;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_PM . " SET deleted = 'yes' WHERE id = '$id' AND to_user = '$to_user'";
		R::exec($sql);
		header("Location: index.php?act=inbox");
	}

	/*
	 * Delete a pm out of the outbox
	 */

	function deleteoutboxpm($fromuser, $id) {
		global $session;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_PM . " SET sent_deleted = 'yes' WHERE from_user = '$fromuser' AND id = '$id'";
		R::exec($sql);
		header("Location: index.php?act=outbox");
	}

	/**
	 * confirmUserPass - Checks whether or not the given
	 * username is in the database, if so it checks if the
	 * given password is the same password in the database
	 * for that user. If the user doesn't exist or if the
	 * passwords don't match up, it returns an error code
	 * (1 or 2). On success it returns 0.
	 */
	function confirmUserPass($username, $password) {
		$this -> connect;

		/* Add slashes if necessary (for query) */
		if (!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}

		/* Verify that user is in database */
		$sql = "SELECT password FROM " . TBL_USERS . " WHERE username = '$username'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		/* Error occurred, return given name by default */
		$num_rows = count($rows);

		/*             * * fetch into an PDOStatement object ** */
		if (!$stmt || ($num_rows < 1)) {
			return 1;
			//Indicates username failure
		}

		/* Retrieve password from result, strip slashes */
		foreach ($rows as $row) {
			$row['password'] = stripslashes($row['password']);
			$password = stripslashes($password);
		}

		/* Validate that password is correct */
		if ($password == $row['password']) {
			return 0;
			//Success! Username and password confirmed
		} else {
			return 2;
			//Indicates password failure
		}
	}

	/*
	 * It returns a number of how many pms the user has
	 */

	function countpms() {
		global $session;
		$this -> connect;
		$sql = "SELECT * " . "FROM " . TBL_PM . " WHERE to_user='$session->username' AND isread='no' AND deleted='no'";
		$stmt = R::getAll($sql);
		$rows = $stmt;
		return count($rows);
	}

	/*
	 * This will move to pm models
	 */

	function displaypms_Model() {
		global $database, $session;
		$this -> connect;
		$sql = "SELECT * " . "FROM " . TBL_PM . " WHERE to_user='$session->username' ORDER BY id DESC";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		/* Error occurred, return given name by default */
		$num_rows = count($rows);
		if (!$stmt || ($num_rows < 0)) {
			echo "Error displaying PMs";
			return;
		}
		if ($num_rows == 0) {
			echo "You have no messages";
			return;
		}
		/* Display table contents */
		echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"product-table\">\n";
		echo "<tr><th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">UNREAD/READ</a></th><th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">id</a></th><th class=\"table-header-repeat line-left minwidth-1\"><a href=\"\">To User</a></th><th class=\"table-header-repeat line-left\"><a href=\"\">From User</a></th><th class=\"table-header-repeat line-left\"><a href=\"\">Message</a></th><th class=\"table-header-repeat line-left\"><a href=\"\">Time Stamp</a></th><th class=\"table-header-repeat line-left\"><a href=\"\">Edits</a></th></tr>\n";
		foreach ($rows as $row) {
			$id = $row['id'];
			$to_user = $row['to_user'];
			$from_user = $row['from_user'];
			$isread = $row['isread'];
			$message = $row['message'];
			$time = $row['timestamp'];

			echo "<tr><td>";
			if ($isread == "no") {
				echo "UNREAD";
			} else if ($isread == "yes") {
				echo "READ";
			}
			echo "</td><td>$id</td><td>$to_user</td><td>$from_user</td><td>$message</td><td>$time</td>
      <td class=\"options-width\">
            <a href=\"deleteinboxpm.php?to_user=$to_user&id=$id\" title=\"Delete\" class=\"icon-2 info-tooltip\"></a>
            <a href=\"sendpm.php?reply=$from_user&quote=$message\" title=\"Reply\" class=\"icon-3 info-tooltip\"></a>";
			if ($isread == "no") {
				echo "<a href=\"inbox.php?readpm=true&to_user=$to_user&id=$id\" title=\"Read\" class=\"icon-5 info-tooltip\"></a>";
			} else if ($isread == "yes") {
				echo "<a href=\"inbox.php?unreadpm=true&to_user=$to_user&id=$id\" title=\"unRead\" class=\"icon-5 info-tooltip\"></a>";
			}
			echo "</td></tr>\n";
		}
		echo "</table><br>\n";
	}

	/*
	 * Display message rows like how many and count them out
	 */

	function countMessages() {
		global $database, $session;
		$this -> connect;
		$sql = "SELECT * " . "FROM " . TBL_PM . " WHERE to_user='$session->username' ORDER BY id DESC";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		if (!$stmt || (count($rows) < 0)) {
			echo "Error displaying PMs";
			return;
		}
		if ($rows == 0) {
			echo "You have no messages";
			return;
		}
		/* Display table contents */
		foreach ($rows as $result) {
			$id = $result['id'];
			$to_user = $result['to_user'];
			$from_user = $result['from_user'];
			$isread = $result['isread'];
			$subject = $result['subject'];
			$message = $result['message'];
			$time = $result['timestamp'];

			echo "ON $time | ";
			if ($isread == "no") {
				echo "UNREAD";
			} else if ($isread == "yes") {
				echo "READ";
			}
			echo "<br />";
			echo "$from_user wrote: $message";
			echo "<br />";
			echo "<a href=\"deleteinboxpm.php?to_user=$to_user&id=$id\" title=\"Delete\" class=\"icon-2 info-tooltip\"></a>
            <a href=\"sendpm.php?reply=$from_user&subject=$subject&quote=$message\" title=\"Reply\" class=\"icon-3 info-tooltip\"></a>";
			if ($isread == "no") {
				echo "<a href=\"inbox.php?readpm=true&to_user=$to_user&id=$id\" title=\"Read\" class=\"icon-5 info-tooltip\"></a>";
			} else if ($isread == "yes") {
				echo "<a href=\"inbox.php?unreadpm=true&to_user=$to_user&id=$id\" title=\"unRead\" class=\"icon-5 info-tooltip\"></a>";
			}
			echo "<br />";
			echo "<hr />";
		}
	}

	/*
	 * This shows the friend requests
	 */

	function showfriendrequests() {
		global $session;
		$this -> connect;
		echo "<h3>The following people are requesting you as a friend</h3>";
		$sql = "SELECT * FROM " . TBL_FRIENDREQUESTS . " WHERE mem2='" . $session -> id . "' ORDER BY id ASC LIMIT 50";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		/* Error occurred, return given name by default */
		$num_rows = count($rows);
		if ($num_rows < 1) {
			echo 'You have no Friend Requests at this time.';
		} else {
			foreach ($rows as $row) {
				$requestID = $row["id"];
				$mem1 = $row["mem1"];
				$sqlName = "SELECT username FROM " . TBL_USERS . " WHERE id='$mem1' LIMIT 1";
				foreach ($dbh->query($sqlName) as $row) {
					$requesterUserName = $row["username"];
				}

				echo '<hr />
<table width="100%" cellpadding="5"><tr><td width="17%" align="left"></td>
                        <td width="83%"><a href="profile.php?id=' . $mem1 . '">' . $requesterUserName . '</a> wants to be your Friend!<br /><br />
					    <span id="req' . $requestID . '">
					    <a href="#" onclick="return false" onmousedown="javascript:acceptFriendRequest(' . $requestID . ');" >Accept</a>
					    &nbsp; &nbsp; OR &nbsp; &nbsp;
					    <a href="#" onclick="return false" onmousedown="javascript:denyFriendRequest(' . $requestID . ');" >Deny</a>
					    </span></td>
                        </tr>
                       </table>';
			}
		}
	}

	/**
	 * confirmUserID - Checks whether or not the given
	 * username is in the database, if so it checks if the
	 * given userid is the same userid in the database
	 * for that user. If the user doesn't exist or if the
	 * userids don't match up, it returns an error code
	 * (1 or 2). On success it returns 0.
	 */
	function confirmUserID($username) {
		$this -> connect;

		/* Add slashes if necessary (for query) */
		if (!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}

		/* Verify that user is in database */
		$sql = R::getAll("SELECT userid FROM " . TBL_USERS . " WHERE username = '$username'");

		if (!$sql || (count($sql) < 1)) {
			return 1;
			//Indicates username failure
		} else {
			return 0;
		}
	}

	/**
	 * usernameTaken - Returns true if the username has
	 * been taken by another user, false otherwise.
	 */
	function usernameTaken($username) {
		$this -> connect;
		if (!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}
		$sql = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		return (count($rows) > 0);
	}

	/**
	 * usernameTaken - Returns true if the username has
	 * been taken by another user, false otherwise.
	 */
	function useridTaken($id) {
		$this -> connect;
		if (!get_magic_quotes_gpc()) {
			$id = addslashes($id);
		}
		$sql = "SELECT id FROM " . TBL_USERS . " WHERE id = '$id'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		return (count($rows) > 0);
	}

	/**
	 * usernameBanned - Returns true if the username has
	 * been banned by the administrator.
	 */
	function usernameBanned($username) {
		$this -> connect;
		if (!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}
		$sql = "SELECT username FROM " . TBL_BANNED_USERS . " WHERE username = '$username'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		return (count($rows) > 0);
	}

	/**
	 * addNewUser - Inserts the given (username, password, email)
	 * info into the database. Appropriate user level is set.
	 * Returns true on success, false otherwise.
	 */
	function addNewUser($username, $password, $birth_day, $birth_month, $birth_year, $email) {
		$this -> connect;
		$birthday = "$birth_year-$birth_day-$birth_month";
		$time = time();
		/* If admin sign up, give admin user level */
		if (strcasecmp($username, ADMIN_NAME) == 0) {
			$ulevel = ADMIN_LEVEL;
		} else {
			$ulevel = USER_LEVEL;
		}

		$users = R::dispense(TBL_USERS);

		$users -> username = $username;
		$users -> password = $password;
		$users -> birthday = $birthday;
		$users -> userid = "0";
		$users -> userlevel = $ulevel;
		$users -> email = $email;
		$users -> email_activated = "0";
		$users -> timestamp = $time;
		$users -> profile_status = "no";
		$users -> online = "no";
		$users -> bio = "";

		$id = R::store($users);
		return R::store($users);
		
	}

	/**
	 * adminaddNewUser - Inserts the given (username, password, email)
	 * info into the database. Appropriate user level is set.
	 * Returns true on success, false otherwise.
	 */
	function adminaddNewUser($username, $password, $birth_day, $birth_month, $birth_year, $email) {
		$this -> connect;
		$birthday = "$birth_year-$birth_day-$birth_month";
		$time = time();
		/* If admin sign up, give admin user level */
		if (strcasecmp($username, ADMIN_NAME) == 0) {
			$ulevel = ADMIN_LEVEL;
		} else {
			$ulevel = USER_LEVEL;
		}
		$users = R::dispense(TBL_USERS);

		$users -> username = $username;
		$users -> password = $password;
		$users -> birthday = $birthday;
		$users -> userid = "0";
		$users -> userlevel = $ulevel;
		$users -> email = $email;
		$users -> email_activated = "0";
		$users -> timestamp = $time;
		$users -> profile_status = "no";
		$users -> bio = "";

		$id = R::store($users);
		return R::store($users);
	}

	/**
	 * updateUserField - Updates a field, specified by the field
	 * parameter, in the user's row of the database.
	 */
	function updateUserField($username, $field, $value) {
		$this -> connect;
		$sql = "UPDATE " . TBL_USERS . " SET " . $field . " = '$value' WHERE username = '$username'";
		R::exec($sql);
	}

	/**
	 * updateUserField - Updates a field, specified by the field
	 * parameter, in the user's row of the database.
	 */
	function adminupdateUserField($username, $field, $value) {
		$this -> connect;
		$sql = "UPDATE " . TBL_USERS . " SET " . $field . " = '$s_value' WHERE username = '$username'";
		return R::exec($sql);
	}

	/**
	 * getConfig -
	 */
	function getConfig($configid) {
		$this -> connect;
		$sql = "SELECT * FROM " . TBL_CONFIG . " WHERE config_id = '$configid'";
		$sth = R::getAll($sql);
		$count = count($sth);
		/* Error occurred, return given name by default */
		if (!$sth || ($count < 1)) {
			return NULL;
		}
		/* Return result array */
		$dbarray = $sth;
		return $dbarray;
	}

	/**
	 * getUserInfo - Returns the result array from a mysql
	 * query asking for all information stored regarding
	 * the given username. If query fails, NULL is returned.
	 */
	function getUserInfo($username) {
		$this -> connect;
		$sql = R::getAll("SELECT * FROM " . TBL_USERS . " WHERE username = '$username'");

		/* Error occurred, return given name by default */
		if (!$sql || (count($sql) < 1)) {
			return NULL;
		}

		return $sql;
	}

	/*
	 * Checks if user is friends with the other
	 */
	function getUserInfofriends($username) {
		$this -> connect;
		$sql = "SELECT friend_array FROM " . TBL_USERS . " WHERE id='$mem1' LIMIT 1";

		$stmt = R::exec($sql);
		$rows = R::getAll($sql);

		/* Error occurred, return given name by default */
		if (!$stmt || (count($rows) < 1)) {
			return NULL;
		}

		$sql = "SELECT * FROM " . TBL_USERS . " WHERE username = '$username'";

		$stmt = R::getAll($sql);

		return $stmt;
	}

	/**
	 * getUserInfoid - Returns the result array from a mysql
	 * query asking for all information stored regarding
	 * the given username. If query fails, NULL is returned.
	 */
	function getUserInfoid($id) {
		$this -> connect;
		$sql = "SELECT * FROM " . TBL_USERS . " WHERE id = '$id'";
		$stmt = R::exec($sql);
		$rows = R::getAll($sql);
		/* Error occurred, return given name by default */
		if (!$stmt || (count($rows) < 1)) {
			return NULL;
		}
		return $rows;
	}

	/**
	 * getNumMembers - Returns the number of signed-up users
	 * of the website, banned members not included. The first
	 * time the function is called on page load, the database
	 * is queried, on subsequent calls, the stored result
	 * is returned. This is to improve efficiency, effectively
	 * not querying the database when no call is made.
	 */
	function getNumMembers() {
		$this -> connect;
		if ($this -> num_members < 0) {
			$sql = "SELECT * FROM " . TBL_USERS;
			$stmt = R::exec($sql);
			$rows = R::getAll($sql);
			$this -> num_members = count($rows);
		}
		return $this -> num_members;
	}

	/**
	 * getNumActiveUsers -
	 */
	function getNumActiveUsers() {
		$this -> connect;
		if ($this -> num_members < 0) {
			$sql = "SELECT * FROM " . TBL_ACTIVEUSERS;
			$stmt = R::exec($sql);
			$rows = R::getAll($sql);
			$this -> num_members = count($rows);
		}
		return $this -> num_members;
	}

	/**
	 * calcNumActiveUsers - Finds out how many active users
	 * are viewing site and sets class variable accordingly.
	 */
	function calcNumActiveUsers() {
		$this -> connect;
		/* Calculate number of users at site */
		$sql = "SELECT * FROM " . TBL_ACTIVE_USERS;
		$stmt = R::exec($sql);
		$fetch = R::getAll($sql);
		$this -> num_active_users = count($fetch);
	}

	/**
	 * calcNumActiveGuests - Finds out how many active guests
	 * are viewing site and sets class variable accordingly.
	 */
	function calcNumActiveGuests() {
		$this -> connect;
		/* Calculate number of guests at site */
		$sql = "SELECT * FROM " . TBL_ACTIVE_GUESTS;
		$stmt = R::exec($sql);
		$fetch = R::getAll($sql);
		$this -> num_active_guests = count($fetch);
	}

	/**
	 * addActiveUser - Updates username's last active timestamp
	 * in the database, and also adds him to the table of
	 * active users, or updates timestamp if already there.
	 */
	function addActiveUser($username, $time) {
		$this -> connect;
		$sql = "UPDATE " . TBL_USERS . " SET timestamp = '$time' WHERE username = '$username'";
		R::exec($sql);
		if (!TRACK_VISITORS)
			return;
		
		R::exec( 'update users set online="yes" where username='.$username.'' );
		
		//$addactiveusers = R::$f->begin()->select('*')->from(TBL_ACTIVE_USERS)->where(' username = ? ')->put($username)->get('row');
		//$count = count($addactiveusers);
		//$addactiveusers = R::find(TBL_ACTIVE_USERS);
		$addactiveusers = R::getAll('select * from '  . TBL_ACTIVE_USERS . ' where username = "' . $username . '"');
		foreach ($addactiveusers as $row) {
			$fusername = $row['username'];
		}
		if ($fusername != $username) {
			$active_users = R::dispense(TBL_ACTIVE_USERS);
			$active_users -> username = $username;
			$active_users -> time = $time;
			$id = R::store($active_users);
		}

		$this -> calcNumActiveUsers();
	}

	/* addActiveGuest - Adds guest to active guests table */

	function addActiveGuest($ip, $time) {
		$this -> connect;
		if (!TRACK_VISITORS)
			return;

		$addactiveusers = R::getAll('select * from '  . TBL_ACTIVE_GUESTS . ' where ip = "' . $ip . '"');
		foreach ($addactiveusers as $row) {
			$fip = $row['ip'];
		}
		if ($fip != $ip) {
			$addactiveguest = R::dispense(TBL_ACTIVE_GUESTS);
			$addactiveguest -> ip = $ip;
			$addactiveguest -> time = $time;
			$id = R::store($addactiveguest);
		}

		$this -> calcNumActiveGuests();
	}

	/* These functions are self explanatory, no need for comments */

	/* removeActiveUser */

	function removeActiveUser($username) {
		$this -> connect;
		if (!TRACK_VISITORS)
			return;
		$sql = R::exec("DELETE FROM " . TBL_ACTIVE_USERS . " WHERE username = '$username'");
		$this -> calcNumActiveUsers();
	}

	/* removeActiveGuest */

	function removeActiveGuest($ip) {
		$this -> connect;
		if (!TRACK_VISITORS)
			return;
		$sql = R::exec("DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE ip = '$ip'");
		$this -> calcNumActiveGuests();
	}

	/* removeInactiveUsers */

	function removeInactiveUsers() {
		$this -> connect;
		if (!TRACK_VISITORS)
			return;
		$timeout = time() - USER_TIMEOUT * 60;
		$sql = R::exec("DELETE FROM active_users WHERE timestamp = $timeout");
		$this -> calcNumActiveUsers();
	}

	/* removeInactiveGuests */

	function removeInactiveGuests() {
		$this -> connect;
		if (!TRACK_VISITORS)
			return;
		$timeout = time() - GUEST_TIMEOUT * 60;
		$sql = "DELETE FROM active_guests WHERE timestamp < $timeout";
		$sql = R::exec("DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE timestamp < $timeout");
		$this -> calcNumActiveGuests();
	}

	/*
	 * PM INSERT
	 */

	/*
	 * Add a pm to the db that the user parses
	 */

	function insertpm($to_user, $from_user, $subject, $message) {
		$this -> connect;
		date_default_timezone_set(timezone);
		$time = date(timeformat, time());

		$pm = R::dispense(TBL_PM);

		$pm -> to_user = $to_user;
		$pm -> from_user = $from_user;
		$pm -> subject = $subject;
		$pm -> message = $message;
		$pm -> timestamp = $time;

		$id = R::store($pm);
		return R::store($pm);
	}

	/*
	 * Activates the user in the dashboard
	 */

	function activateuser($id) {
		global $session, $database;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_USERS . " SET email_activated = '1' WHERE id = '$id'";
		R::exec($sql);
		header("Location: " . $session -> referrer);
	}

	/*
	 * Deactivates the user in the dashboard
	 */

	function deactivateuser($id) {
		global $session, $database;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_USERS . " SET email_activated = '0' WHERE id = '$id'";
		R::exec($sql);
		header("Location: " . $session -> referrer);
	}

	/*
	 * Unbans the user
	 */
	function unbanuser($id) {
		global $session, $database;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_USERS . " SET banned = 'no' WHERE id = '$id'";
		R::exec($sql);
		header("Location: " . $session -> referrer);
	}

	/*
	 * bans the user
	 */
	function banuser($id) {
		global $session, $database;
		$this -> connect;
		$id = (int)$id;
		$sql = "UPDATE " . TBL_USERS . " SET banned = 'yes' WHERE id = '$id'";
		R::exec($sql);
		header("Location: " . $session -> referrer);
	}

}

/* Create database connection */
$database = new mysqlDB;
?>