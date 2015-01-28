<?php

use Carbon\Carbon as Carbon;

class Autoship extends Eloquent {

    // Mass Assignment
    protected $guarded = array('id','created_at','updated_at','deleted_at');

    protected $fillable = array('autoshipfrequency_id','starting_at');

    // Relationships
    public function orders() {
        return $this->hasMany('Order');
    }

    public function autoshipfrequency() {
        return $this->belongsTo('Autoshipfrequency');
    }

    // Accessors
    public function getStartingAtAttribute($value) {
        return new Carbon($value);
    }

    public function getLastOrderAttribute() {
        return $this->orders()->orderBy('date','desc')->withTrashed()->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Next order
    |--------------------------------------------------------------------------
    |
    */

    public function getNextOrderAttribute() {
        return new Carbon($this->lastOrder->date."+".$this->autoshipfrequency->name);
    }

}