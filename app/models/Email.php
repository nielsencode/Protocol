<?php

class Email extends Eloquent {

	/* Mass assignment */
	protected $fillable = array('emailable_id','emailable_type','message');
	
	/* Relationships */
	public function emailable() {
		return $this->morphTo();
	}

}