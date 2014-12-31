<?php

class Client extends Eloquent {

	protected $softDelete = true;

	/* Events */
	public static function boot() {
		parent::boot();

		self::saving(function($client) {
			$client->fulltext();
		});
	}

	/* Mass assignment */
	protected $guarded = array('id','created_at','updated_at','fulltext','deleted_at');
	
	protected $fillable = array('user_id','subscriber_id','first_name','last_name','email');
	
	/* Relationships */
	public function addresses() {
		return $this->morphMany('Address','addressable');
	}

	public function orders() {
		return $this->hasMany('Order');
	}

	public function protocols() {
		return $this->hasMany('Protocol');
	}

	public function subscriber() {
		return $this->belongsTo('Subscriber');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function name() {
		return $this->first_name.' '.$this->last_name;
	}

	/* Fulltext */
	public function fulltext() {
		$fields = array(
			'first_name',
			'last_name',
			'email'
		);

		$fulltext = array_intersect_key($this->toArray(),array_flip($fields));
		$this->fulltext = implode(' ',$fulltext);
	}

}