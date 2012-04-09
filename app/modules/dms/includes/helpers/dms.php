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
class Dms {

    function Dms() {
        
    }
    
    // Displays the Version of DMS just by calling it
    function version() {
        return Version;
    }
    
    // Displays the website name just by calling it
    function websitename() {
        return site_name;
    }
    
    // Calls the url
    function url() {
        return dyn_www;
    }
    
    // Displays the Powered By Link
    function poweredby() {
        return POWERED_BY;
    }
    
    /*
     * This is a little addon for sending the user to the 
     * top of the page
     */
    function toppage() {
        return '<a rel="nofollow" href="#top" id="backtotop" title="Go to top">Go to top</a>';
    }

}

/**
 * Initialize design object
 */
$dms = new Dms;
?>