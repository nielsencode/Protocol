<?php

class Token extends Eloquent {

	/* Events */
	public static function boot() {
		parent::boot();
		
		self::creating(function($token) {
			$token->makeToken();
			$token->makeExpiration();
		});
	}
	
	/* Mass assignment */
	protected $fillable = array('expires_at');
	
	/* Relationships */
	public function user() {
		return $this->hasOne('User');
	}
	
	/* Mutators */
	public function setTokenAttribute($value) {
		return false;
	}
	
	/* Make a unique, secure token */
	private function makeToken() {
		$salt = 'youth';
		$this->attributes['token'] = substr(sha1(uniqid($salt,true)),0,20);
	}
	
	/* Default expiration date */
	private function makeExpiration() {
		if(isset($this->attributes['expires_at'])) {
			return false;
		}

		$this->attributes['expires_at'] = time()+(60*60);
	}
	
	/* Check if token is expired */
	public function expired() {
		if($this->attributes['expires_at']==-1) {
			return false;
		}

		return time()>=$this->attributes['expires_at'] ? true : false;
	}

}