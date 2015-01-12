<?php

Route::group(['before'=>'auth'],function() {

	foreach(File::files(__DIR__) as $partial) {
		require_once $partial;
	}

});