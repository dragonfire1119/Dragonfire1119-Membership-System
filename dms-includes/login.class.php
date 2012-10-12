<?php
/**************************************************************************
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
**************************************************************************/

class Login {

    private function __construct() {

    }

    /**
     * This logs the user in sence DMS is state less there's no global sessions
     *
     * @param type $user
     * @param type $password
     * @param type $remeber
     */
    public static function user($user, $password, $remember = NULL) {
        $query = $dms->getAll('select * from users where username = :username AND password = :password', array(
                    ':username' => $user,
                    ':password' => $password
                        )
        );

        $count = $dms->count($query);

        if ($count == 1) {
            if ($remember == true) {
                $expire = time() + 60 * 60 * 24 * 30;
                setcookie("username", $user, $expire);
                setcookie("remeber", $remeber, $expire);
            } else {
                setcookie("username", $user);
                setcookie("remeber", $remeber);
            }
        } else {
            return false;
        }
    }

}