<?php
/* * ************************************************************************
 * Dragonfire1119 Membership System AKA DMS
 * Copyright (C) 2012 Christopher Hicks
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * ************************************************************************ */

require_once 'dms-includes/bootstrap.php';
if (isset($_POST['halper'])) {
    if ($_POST['password'] == $_POST['cpassword']) {
        Register::registerUser($_POST['username'], $_POST['email'], $_POST['password']);
    }
}
?>
<form action="" method="post">
    Username: <input type="text" name="username"><br />
    Email: <input type="email" name="email"><br />
    Password: <input type="password" name="password"><br />
    Confirm Password: <input type="password" name="cpassword"><br />
    <input type="hidden" name="helper">
    <input type="submit" value="Sign Up">
</form>