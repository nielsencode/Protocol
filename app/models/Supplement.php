<?php

class Supplement extends Eloquent {

	/*
	|--------------------------------------------------------------------------
	| Events
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot() {
		parent::boot();

		self::saving(function($supplement) {
			$supplement->fulltext();
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Mass assignment
	|--------------------------------------------------------------------------
	|
	*/

	protected $guarded = array('id','fulltext');

	protected $fillable = array('name','subscriber_id','description','short_description','price');

	/*
	|--------------------------------------------------------------------------
	| Soft deletes
	|--------------------------------------------------------------------------
	|
	*/

	protected $softDelete = true;

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	public function protocols() {
		return $this->hasMany('Protocol');
	}

	public function subscriber() {
		return $this->belongsTo('Subscriber');
	}

	/*
	|--------------------------------------------------------------------------
	| Fulltext
	|--------------------------------------------------------------------------
	|
	*/

	public function fulltext() {
		$fields = array(
			'name',
			'description'
		);

		$fulltext = array_intersect_key($this->toArray(),array_flip($fields));
		$this->fulltext = implode(' ',$fulltext);
	}

}