<?php

namespace Supplements;

class OrderComposer {

    public function compose($view) {
        foreach(\Autoshipfrequency::all() as $frequency) {
            $frequencies[$frequency->id] = $frequency->name;
        }

        $data = array(
            'frequencies'=>$frequencies
        );

        $view->with($data);
    }
}