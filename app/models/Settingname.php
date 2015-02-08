<?php

class Settingname extends Eloquent {

	public $timestamps = false;

	protected $fillable = ['inputtype_id','settinggroup_id','name','values','default','description','maxlength'];

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

	public function getDefaultAttribute($value) {
		if($this->inputtype['name']=='list') {
			return json_decode($value,true);
		}

		return $value;
	}

}