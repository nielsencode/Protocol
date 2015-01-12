<?php

class AutoshipController extends BaseController {

    public static function generateOrders() {
        foreach(Autoship::all() as $autoship) {
            $nextOrder = $autoship->orders()->where('date','like',$autoship->next_order->format('Y-m-d')."%");

            if(!$nextOrder->count()) {
                $lastOrder = $autoship->orders()->orderBy('date','desc')->first();

                $orderData = array_merge($lastOrder->toArray(),array(
                    'date'=>$autoship->next_order
                ));

                Order::create($orderData);
            }
        }
    }

}