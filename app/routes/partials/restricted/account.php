<?php

Route::group(['prefix'=>'account'],function() {

	Route::get('/',['as'=>'my account',function() {

		switch(Auth::user()->role->name) {
			case 'client':
				return (new ClientController)->getAccount(Auth::user()->client);
			default:
				return (new UserController)->getUser(Auth::user());
		}

	}]);

	Route::group(['prefix'=>'/edit','as'=>'edit my account'],function() {

		Route::get('/',function() {

			switch(Auth::user()->role->name) {
				case 'client':
					return (new ClientController)->getEditAccount(Auth::user()->client);
				default:
					return (new UserController)->getEdit(Auth::user());
			}

		});

		Route::post('/',function() {

			switch(Auth::user()->role->name) {
				case 'client':
					return (new ClientController)->postEditAccount(Auth::user()->client);
				default:
					return (new UserController)->postEdit(Auth::user());
			}

		});

	});

});

