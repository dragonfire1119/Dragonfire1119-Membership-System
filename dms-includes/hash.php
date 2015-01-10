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

class Hash {

    /**
     * Hash a password using the Bcrypt hashing scheme.
     *
     * <code>
     * 		// Create a Bcrypt hash of a value
     * 		$hash = Hash::make('secret');
     *
     * 		// Use a specified number of iterations when creating the hash
     * 		$hash = Hash::make('secret', 12);
     * </code>
     *
     * @param  string  $value
     * @param  int     $rounds
     * @return string
     */
    public static function make($value) {

        return password_hash($value, PASSWORD_BCRYPT);
    }

    /**
     * Determine if an unhashed value matches a Bcrypt hash.
     *
     * @param  string  $value
     * @param  string  $hash
     * @return bool
     */
    public static function check($value, $hash) {
        return password_verify($value, $hash);
    }
}