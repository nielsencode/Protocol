<?php

class Address extends Eloquent {

	/* Mass assignment */
	protected $guarded = array('id','created_at','updated_at');

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

}