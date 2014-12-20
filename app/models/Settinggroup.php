<?php

class Settinggroup extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('scope_id','name');

	public function scope() {
		return $this->belongsTo('Scope');
	}

	public function settingnames() {
		return $this->hasMany('Settingname');
	}

}