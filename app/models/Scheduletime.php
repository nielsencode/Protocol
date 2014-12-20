<?php

class Scheduletime extends Eloquent {

	public $timestamps = false;

	/* Mass assignment */
	protected $guarded = array('id');

	protected $fillable = array('name');
	
	/* Relationships */
	public function schedules() {
		return $this->hasMany('Schedule');
	}

}