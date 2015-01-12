<?php

class Autoshipfrequency extends Eloquent {

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    |
    */

    protected $guarded = array('id');

    protected $fillable = array('name');

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    public function autoships() {
        return $this->hasMany('Autoship');
    }

}