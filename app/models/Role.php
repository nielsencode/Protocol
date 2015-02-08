<?php

class Role extends Eloquent {

	/**
	 * Timestamps
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Mass assignment
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	public function users() {
		return $this->hasMany('User');
	}
	
	public function permissions() {
		return $this->morphMany('Permission','agent');
	}

}