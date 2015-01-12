<?php

class Addresstype extends Eloquent {

	public $timestamps = false;

	/* Mass assignment */
	protected $guarded = array('id');
	
	protected $fillable = array('name');
	
	/* Relationships */
	public function addresses() {
		return $this->hasMany('Address');
	}

}