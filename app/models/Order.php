<?php

use Carbon\Carbon as Carbon;

class Order extends Eloquent {

    protected $softDelete = true;

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    |
    */

    public static function boot() {
        parent::boot();

        self::saving(function($order) {
            $order->fulltext();
        });

        self::creating(function($order) {
            $order->orderId();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    |
    */

    protected $guarded = array('id','fulfilled_at','created_at','updated_at','fulltext','order_id');

    protected $fillable = array('client_id','supplement_id','quantity','date','autoship_id');

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    */

    public function client() {
        return $this->belongsTo('Client');
    }

    public function supplement() {
        return $this->belongsTo('Supplement');
    }

    public function autoship() {
        return $this->belongsTo('Autoship');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    |
    */

    public function getOrderIdAttribute($value) {
        return str_pad($value,6,0,STR_PAD_LEFT);
    }

    public function getDateAttribute($value) {
        return new Carbon($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Fulltext
    |--------------------------------------------------------------------------
    |
    */

    public function fulltext() {
        $fulltext = array(
            'client_name'=>$this->client->name(),
            'quantity'=>$this->quantity,
            'supplement'=>$this->supplement->name,
            'price'=>$this->supplement->price,
            'order_id'=>$this->order_id
        );

        $this->fulltext = implode(' ',$fulltext);
    }

    /*
    |--------------------------------------------------------------------------
    | OrderId
    |--------------------------------------------------------------------------
    |
    */

    public function orderId() {
        $lastOrder = $this->client->subscriber->orders()->withTrashed()->orderBy('orders.order_id','desc')->first();
        $this->order_id = $lastOrder ? $lastOrder->order_id+1 : 1;
    }
}