<?php

Route::group(['prefix'=>'uploads'],function() {

	Route::get('/{file}',function($file) {

		if(!Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->over('Setting')
		) {
			return false;
		}

		$path = public_path() . "/assets/uploads/$file";

		$file = new \Symfony\Component\HttpFoundation\File\File($path);

		$headers = array(
			'Content-type'=>$file->getMimeType()
		);

		$response = Response::make(File::get($path),200,$headers);

		ob_end_clean();

		return $response;

	});

});