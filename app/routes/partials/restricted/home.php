<?php

Route::get('home',['as'=>'home',function() {

	switch(Auth::user()->role->name) {
		case 'client':
			return Redirect::route('my profile');
		case 'admin':
			return Subscriber::current()->setting('enable orders') ?
				Redirect::route('orders') :
				Redirect::route('clients');
		case 'subscriber':
			return Subscriber::current()->setting('enable orders') ?
				Redirect::route('orders') :
				Redirect::route('clients');
		case 'protocol':
			return Subscriber::current()->setting('enable orders') ?
				Redirect::route('orders') :
				Redirect::route('clients');
	}

}]);