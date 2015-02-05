<?php

class Setting extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('settingable_type','settingable_id','settingname_id','value');

	public function settingname() {
		return $this->belongsTo('Settingname');
	}

	public function scopeNamed($query,$name) {
		return $query
			->join('settingnames','settingnames.id','=','settings.settingname_id')
			->where('settingnames.name',$name);
	}

	public function getValueAttribute($value) {
		if($this->settingname->inputtype->name=='list') {
			return json_decode($value,true);
		}

		return $value;
	}

}