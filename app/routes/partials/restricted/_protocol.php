<?php

if(Auth::user()->role->name=='protocol') {

	Route::group(['prefix'=>'_protocol'],function() {

		Route::get('invite-all-users',function() {
			foreach(Subscriber::current()->users()->where('password','=',NULL)->get() as $user) {
				(new UserController)->newAccountInvitation($user);
			}
		});

	});

}