<?php

class Subscriber extends Eloquent {

	/**
	 * Soft deletes
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	/**
	 * Mass assignment
	 *
	 * @var array
	 */
	protected $fillable = ['name','email','subdomain'];

	/**
	 * Model event handlers
	 */
	public static function boot()
	{
		parent::boot();

		self::deleting(function($subscriber) {
			$subscriber->settings()->delete();
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	public function users() {
		return $this->belongsToMany('User');
	}
	
	public function clients() {
		return $this->hasMany('Client');
	}

	public function supplements() {
		return $this->hasMany('Supplement');
	}
	
	public function addresses() {
		return $this->morphMany('Address');
	}

	public function orders() {
		return $this->hasManyThrough('Order','Client');
	}

	public function protocols() {
		return $this->hasManyThrough('Protocol','Client');
	}

	public function settings() {
		return $this->morphMany('Setting','settingable');
	}

	/**
	 * Get the current subscriber.
	 *
	 * @return bool|Subscriber
	 */
	public static function current() {
		$hostParts = explode('.',$_SERVER['HTTP_HOST']);

		$subdomain = array_shift($hostParts);

		$host = gethostname();

		if($subdomain==$host) {
			$subdomain = null;
		}

		$subscriber = Subscriber::where('subdomain',$subdomain);

		if(!$subscriber->count()) {
			return false;
		}

		return $subscriber->first();
	}

	/**
	 * Get a Subscriber setting value by name.
	 *
	 * @param $name
	 * @return string
	 */
	public function setting($name) {
		$settingname = Settingname::where('name',$name);

		if(!$settingname->count()) {
			return false;
		}

		$settings = $this
			->settings()
			->named($name);

		if($settings->count()) {
			return $settings->first()->value;
		}

		return $settingname->first()->default;
	}
}