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

class Api {

    function Api() {
        
    }
    
    /*
     * This is if you want to add api from google
     * you can put this function on any page that you create
     * by doing 
     * $api->google(Then your api);
     */
    function google($api) {
        return $api;
    }
    
    /*
     * This is if you want to add api from yahoo
     * you can put this function on any page that you create
     * by doing 
     * $api->yahoo(Then your api);
     */
    function yahoo($api) {
        return $api;
    }
    
    /*
     * This is if you want to add api from facebook
     * you can put this function on any page that you create
     * by doing 
     * $api->facebook(Then your api);
     */
    function facebook($api) {
        return $api;
    }
    
    /*
     * This is if you want to add api from any other site
     * you can put this function on any page that you create
     * by doing 
     * $api->other(Then your api);
     */
    function other($api) {
        return $api;
    }

}

/**
 * Initialize design object
 */
$api = new Api;
?>