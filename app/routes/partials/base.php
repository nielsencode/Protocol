<?php

Route::group(['prefix'=>'/'],function() {

	foreach(File::files(__DIR__) as $partial) {
		require_once $partial;
	}

	require_once __DIR__.'/restricted/base.php';

});