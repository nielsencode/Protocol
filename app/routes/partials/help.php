<?php

Route::group(['prefix'=>'help','as'=>'help'],function() {

	Route::get('/',[
		'uses'=>'HelpController@getIndex'
	]);

	Route::post('/',[
		'uses'=>'HelpController@postIndex'
	]);

});