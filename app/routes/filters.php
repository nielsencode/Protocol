<?php

Route::filter('subscriber',function() {

	if(!Subscriber::current()) {
		App::abort(404);
	}

});

Route::filter('enable orders',function() {

	if(!Subscriber::current()->setting('enable orders')) {
		App::abort(404);
	}

});