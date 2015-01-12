<?php

class EmailController extends BaseController {

	public static function record($emailable,$message) {

		Email::create(array(
			'emailable_id'=>$emailable->id,
			'emailable_type'=>get_class($emailable),
			'message'=>$message
		))->save();

	}

}