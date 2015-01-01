<?php

Route::group(['prefix'=>'contact','as'=>'contact','domain'=>Config::get('app.url')],function() {

	Route::get('/',[
		'uses'=>'ContactController@getIndex'
	]);

	Route::post('/',[
		'uses'=>'ContactController@postIndex'
	]);

});