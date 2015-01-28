<?php

class AutoshipController extends BaseController {

    public static function generateOrders() {
        if(!Subscriber::current()->setting('enable orders')) {
            return;
        }

        foreach(Autoship::all() as $autoship) {

            if($autoship->nextOrder->isToday()) {
                $data = array_merge($autoship->lastOrder->toArray(),[
                    'date'=>\Carbon\Carbon::now()
                ]);

                Order::create($data);
            }

        }
    }

}