<?php

class Protocol extends Eloquent {

	/* Mass assignment */
	protected $fillable = array('supplement_id','client_id');
	
	/* Relationship */
	public function client() {
		return $this->belongsTo('Client');
	}
	
	public function supplement() {
		return $this->belongsTo('Supplement');
	}
	
	public function schedules() {
		return $this->hasMany('Schedule');
	}

}