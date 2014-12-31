<?php

class Email extends Eloquent {

	/* Mass assignment */
	protected $fillable = array('emailable_id','emailable_type','message');

	/* Mutators */
	public function setMessageAttribute($value) {
		return serialize($value);
	}
	
	/* Relationships */
	public function emailable() {
		return $this->morphTo();
	}

}