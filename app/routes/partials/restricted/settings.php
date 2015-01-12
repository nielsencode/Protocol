<?php

Route::group(['prefix'=>'settings'],function() {

	Route::group(['prefix'=>'/','as'=>'settings'],function() {

		Route::get('',[
			'uses'=>'SettingController@getIndex'
		]);

		Route::post('',[
			'uses'=>'SettingController@postIndex'
		]);

	});

});