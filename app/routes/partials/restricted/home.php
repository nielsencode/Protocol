<?php

Route::get('',['as'=>'home',function() {

	switch(Auth::user()->role->name) {
		case 'client':
			return Redirect::route('my profile');
		case 'admin':
			return Redirect::route('orders');
		case 'subscriber':
			return Redirect::route('orders');
		case 'protocol':
			return Redirect::route('orders');
	}

}]);