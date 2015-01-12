<?php

Route::group(['prefix'=>'help','as'=>'help'],function() {

	Route::any('/',function() {
		return Redirect::route('contact');
	});

});