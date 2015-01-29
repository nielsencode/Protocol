<?php

if(Auth::user() && Auth::user()->role->name=='protocol') {

	Route::group(['prefix'=>'_protocol'],function() {

		Route::get('invite-all-users',function() {
			foreach(Subscriber::current()->users()->where('password','=',NULL)->get() as $user) {
				(new UserController)->newAccountInvitation($user);
			}
		});

		Route::get('orders',function() {
			foreach(Subscriber::current()->orders()->orderBy('date','desc')->get() as $order) {
				echo "{$order->supplement->name} | {$order->client->name()} | {$order->date}<br>";
			}
		});

	});

}