<?php

Route::group(['prefix'=>'timezone'],function() {

	Route::post('/set',function() {
		Timezone::set('user',Input::get('name'));
	});

});
