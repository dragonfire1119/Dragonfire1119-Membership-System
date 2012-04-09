<?php

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