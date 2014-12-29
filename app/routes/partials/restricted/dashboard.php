<?php

Route::get('dashboard',function() {

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
		AND addresstypes.name = :addresstype
		GROUP BY city
		ORDER BY city ASC
	";

	$bindings = array(
		'Client',
		'shipping'
	);

	$results = DB::select($statement,$bindings);

	//export($results);

	return View::make('dashboard.index',array('cities'=>$results));

});