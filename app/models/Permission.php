<?php

class Permission extends Eloquent {

	/* Mass assignment */
	protected $guarded = array('id','created_at','updated_at');

	protected $fillable = array('agent_type','agent_id','resource_type','resource_id','scope');

	/* Relationships */
	public function actions() {
		return $this->belongsToMany('Action');
	}

	public function scope() {
		return $this->belongsTo('Scope');
	}

}