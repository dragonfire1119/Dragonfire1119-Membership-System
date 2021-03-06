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

class Register {

    private function __construct() {

    }

    /**
     * This registers the user and for the if statement it's just a secandary trigger.
     * 
     * @param type $user
     * @param type $email
     * @param type $password
     * @param type $extras
     * @return boolean
     */
    public static function user($user, $email, $password, $extras=NULL) {
        if (!empty($user) && !empty($email) && $password) {
            $user = R::dispense('users');
            $user->username = $user;
            $user->email = $email;
            $user->password = $password;
            foreach ($extras as $key => $value) {
                $user->$key = $value;
            }
            $id = R::store($user);
            return true;
        } else {
            return false;
        }
    }

}