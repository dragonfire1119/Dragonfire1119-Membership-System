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

class Html {
    
	public $doctype = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
";
	public $html = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
";
	public $head = "<head>
";
	public $endhead = "</head>
";
	public $body = "<body>
";
	public $endbody = "
</body>
";
	public $endhtml = "</html>
";
	
    function Html() {
        
    }
    
    /*
     * Makes it easy for people to use the title on any page
     */
    function title($text) {
        echo '<title>'.$text.'</title>
';
    }
    
    /*
     * Makes URLs easy for people that have no knowledge of html links
     */
    function url($url, $object_name, $name) {
        echo '<a href="' . $url . '" name="' . $object_name . '" >' . $name . '</a>';
    }
    
    function h1($text) {
        echo '<h1>' . $text . '</h1>';
    }

    function p($text) {
        echo '<p>' . $text . '</p>';
    }
    
    function image($url, $source) {
        echo '<img src="$url" alt="$source"/> ';
    }
}

/**
 * Initialize design object
 */
$html = new Html;
?>