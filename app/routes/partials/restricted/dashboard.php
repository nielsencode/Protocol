<?php

Route::get('dashboard',function() {

	if(!Auth::user()->role->name=='protocol') {
		App::abort(404);
	}

	$statement = "
		SELECT
			addresses.latitude,
			addresses.longitude,
			CONCAT(addresses.city,', ',addresses.state) AS city,
			COUNT(*) AS clients
		FROM addresses
		JOIN addresstypes
		ON addresstypes.id = addresses.addresstype_id
		WHERE addresses.addressable_type = :addressable_type
		AND addresses.latitude IS NOT NULL
		AND addresses.longitude IS NOT NULL
		AND addresstypes.name = :addresstype
		GROUP BY city
		ORDER BY city ASC
	";

	$bindings = array(
		'Client',
		'shipping'
	);

	$results = DB::select($statement,$bindings);

	return View::make('dashboard.index',array('cities'=>$results));

});