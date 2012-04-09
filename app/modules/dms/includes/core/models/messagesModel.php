<?php

/**
 * 
 */
class messagesModel {
	
	function __construct() {
		
	}
	
	function sendmessage($from, $to, $message) {
		
		$messages = R::dispense("messages");
		$messages->from();
		$messages->to();
		$messages->message();
		$id = R::store($messages);
		
	}
}
