<?php

Route::group(['prefix'=>'forgot-password','as'=>'forgot password'],function() {

	Route::get('/',[
		'uses'=>'AuthController@getForgotPassword'
	]);

	Route::post('/',[
		'uses'=>'AuthController@postForgotPassword'
	]);

});

Route::group(['prefix'=>'login','as'=>'login'],function() {

	Route::get('/',[
		'before'=>'guest',
		'uses'=>'AuthController@getLogin'
	]);

	Route::post('/',[
		'uses'=>'AuthController@postLogin'
	]);

});

Route::get('logout',[
	'as'=>'logout',
	'uses'=>'AuthController@getLogout'
]);

Route::group(['prefix'=>'reset-password','as'=>'reset password','before'=>'guest'],function() {

	Route::get('/',[
		'uses'=>'AuthController@getResetPassword'
	]);

	Route::post('/',[
		'uses'=>'AuthController@postResetPassword'
	]);

});

Route::group(['prefix'=>'set-password','as'=>'set password'],function() {

	Route::get('/',[
		'uses'=>'AuthController@getSetPassword'
	]);

	Route::post('/',[
		'uses'=>'AuthController@postSetPassword'
	]);

});

Route::get('/new-account-invitation',[
	'as'=>'new account invitation',
	'uses'=>'UserController@getNewAccountInvitation'
]);