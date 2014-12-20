<?php

class MailLib {

	public static function send($obj,$message,$data,$callback) {
		Mail::send($message,$data,$callback);
		
		if(is_array($message)) {
			$message = array_values($message)[0];
		}
		
		Email::create(array(
			'emailable_id'=>$obj->id,
			'emailable_type'=>get_class($obj),
			'message'=>$message
		))->save();
	}

}