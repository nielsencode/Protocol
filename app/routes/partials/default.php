<?php

Route::get('/',['as'=>'landing',function() {

	if (Subscriber::current()) {
		return Redirect::route('home');
	}

	App::abort(404);
	//return View::make('landing.index');

}]);