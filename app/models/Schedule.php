<?php

class Schedule extends Eloquent {

	/* Mass assignment */
	protected $fillable = array('protocol_id','scheduletime_id','prescription');
	
	/* Relationships */
	public function protocol() {
		return $this->belongsTo('Protocol');
	}
	
	public function scheduletime() {
		return $this->belongsTo('Scheduletime');
	}

}