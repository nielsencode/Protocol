<?php

class Role extends Eloquent {

	public $timestamps = false;

	/* Mass assignment */
	protected $guarded = array('id');
	
	/* Relationships */
	public function users() {
		return $this->hasMany('User');
	}
	
	public function permissions() {
		return $this->morphMany('Permission','agent');
	}

}