<?php

class Subscriber extends Eloquent {

	/*
	|--------------------------------------------------------------------------
	| Soft deletes
	|--------------------------------------------------------------------------
	|
	*/

	protected $softDelete = true;

	/*
	|--------------------------------------------------------------------------
	| Mass assignment
	|--------------------------------------------------------------------------
	|
	*/

	protected $fillable = array('name','email','subdomain');

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	public function users() {
		return $this->hasMany('User');
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

	/*
	|--------------------------------------------------------------------------
	| Current subscriber
	|--------------------------------------------------------------------------
	|
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

		return $settingname->pluck('default');
	}
}