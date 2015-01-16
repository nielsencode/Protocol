<?php

class Settingname extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('inputtype_id','settinggroup_id','name','values','default','description');

	public function inputtype() {
		return $this->belongsTo('Inputtype');
	}

	public function settinggroup() {
		return $this->belongsTo('Settinggroup');
	}

	public function settings() {
		return $this->hasMany('Setting');
	}

	public function getValuesAttribute($values) {
		return explode(',',$values);
	}

}