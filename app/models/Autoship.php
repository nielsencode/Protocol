<?php

use Carbon\Carbon as Carbon;

class Autoship extends Eloquent {

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    |
    */

    protected $guarded = array('id','created_at','updated_at','deleted_at');

    protected $fillable = array('autoshipfrequency_id','starting_at');

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    public function orders() {
        return $this->hasMany('Order');
    }

    public function autoshipfrequency() {
        return $this->belongsTo('Autoshipfrequency');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    |
    */

    public function getStartingAtAttribute($value) {
        return new Carbon($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Next order
    |--------------------------------------------------------------------------
    |
    */

    public function getNextOrderAttribute() {
        $start = $this->starting_at;
        $now = new Carbon('today');
        $interval = $now->diff($start);

        switch(true) {
            case $interval->days==0:
                $next_order = $now;
                break;
            case $interval->invert==0:
                $next_order = $start;
                break;
            case $interval->invert==1:
                $frequency = intval($this->autoshipfrequency->name);
                $multiple = ceil($interval->days/$frequency);
                $next_order = new Carbon($start." +".$multiple*$frequency." days");
        }

        return $next_order;
    }

}