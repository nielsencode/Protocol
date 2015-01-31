<?php

Route::bind('client',function($value,$route) {
	$client = Client::where('id',$value);

	if(!$client->count()) {
		App::abort(404);
	}

	return $client->with('protocols')->first();
});

Route::model('order','Order');

Route::model('protocol','Protocol');

Route::model('supplement','Supplement');

Route::model('user','User');

Route::bind('cancelledOrder',function($value,$route) {
	$order = Order::where('id',$value)->withTrashed();

	if(!$order->count()) {
		App::abort(404);
	}

	return $order->first();
});