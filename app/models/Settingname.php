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

	public function getSubscriberValueAttribute() {
		if(!Subscriber::current()) {
			return false;
		}

		$setting = Setting::where('settingable_type','Subscriber')
			->where('settingable_id',Subscriber::current()->id)
			->where('settingname_id',$this->id);

		if($setting->count()) {
			return $setting->first()->value;
		}

		return $this->default;
	}

}