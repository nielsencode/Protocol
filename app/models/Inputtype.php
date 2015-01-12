<?php

class Inputtype extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('name');

	public function settingnames() {
		return $this->hasMany('Settingname');
	}

}