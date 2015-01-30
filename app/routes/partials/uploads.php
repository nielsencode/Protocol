<?php

Route::group(['prefix'=>'images'],function() {

	Route::get('/{file}',function($file) {

		if(!Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Setting')
		) {
			return false;
		}

		$path = public_path() . "/assets/uploads/$file";

		$headers = array('Content-type'=>'image/png');

		$response = Response::download($path,$file,$headers);

		ob_end_clean();

		return $response;

	});

});