<?php

class Scope extends Eloquent {

	public $timestamps = false;

	/* Mass assignment */
	protected $guarded = array('id');

	protected $fillable = array('name');

	/* Relationships */
	public function permissions() {
		return $this->hasMany('Permission');
	}

	public function settinggroups() {
		return $this->hasMany('Settinggroup');
	}

}