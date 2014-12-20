<?php

class Action extends Eloquent {

	public $timestamps = false;

	/* Mass assignment */
	protected $guarded = array('id');

	protected $fillable = array('name');

	/* Relationships */

	public function permissions() {
		return $this->belongsToMany('Permission');
	}

}