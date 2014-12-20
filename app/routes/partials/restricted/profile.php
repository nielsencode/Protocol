<?php

if(Auth::user() && Auth::user()->role->name!='client') {
	return;
}

Route::group(['prefix'=>'profile'],function() {

	Route::get('/',['as'=>'my profile',function() {

		return (new ClientController)->getClient(Auth::user()->client);

	}]);

	Route::group(['prefix'=>'/edit','as'=>'edit my profile'],function() {

		Route::get('/',function() {
			return (new ClientController)->getEdit(Auth::user()->client);
		});

		Route::post('/',function() {
			return (new ClientController)->postEdit(Auth::user()->client);
		});

	});

});