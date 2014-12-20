<?php

class Setting extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('settingable_type','settingable_id','settingname_id','value');

	public function settingname() {
		return $this->belongsTo('Settingname');
	}

}