<?php

class Address extends Eloquent {

	public static function boot() {
		parent::boot();

		self::saving(function($address) {
			//$address->location();
		});
	}

	/* Mass assignment */
	protected $guarded = array('id','longitude','latitude','created_at','updated_at');

	protected $fillable = array('addressable_id','addressable_type','addresstype_id','address','city','state','zip','phone');

	/* Scopes */
	public function scopeOfType($query,$type) {
		$addresstypeId = Addresstype::where('name',$type)->first()['id'];
		return $query->where('addresstype_id',$addresstypeId);
	}
	
	/* Relationships */
	public function addresstype() {
		return $this->belongsTo('Addresstype');
	}
	
	public function addressable() {
		return $this->morphTo();
	}

	/* Accessors */
	public function getPhoneAttribute($value) {
		return substr($value,strlen($value)-10,3).'-'.substr($value,strlen($value)-7,3).'-'.substr($value,strlen($value)-4,4);
	}
	
	/* Mutators */
	public function setPhoneAttribute($value) {
		$this->attributes['phone'] = preg_replace('/[^0-9]/','',$value);
	}

	public function formatAddress() {
		return $this->address.'<br>'.$this->city.', '.$this->state.' '.$this->zip;
	}

	public function location() {
		$format = "%s, %s";

		$bindings = array(
			$this->city,
			$this->state
		);

		$address = vsprintf($format,$bindings);

		$location = location($address);

		if(!$location) {
			return false;
		}

		$this->latitude = $location->geometry->location->lat;
		$this->longitude = $location->geometry->location->lng;
	}

}