<?php

Route::group(['prefix'=>'import'],function() {

	if(Auth::user() && Auth::user()->role->name!='protocol') {
		App::abort(404);
	}

	Route::get('/protocols',function() {

		$path = public_path().'/assets/imports/'.Subscriber::current()->subdomain.'/protocols.csv';

		$data = file_get_contents($path);

		$migrate = Migrate::import($data,public_path().'/assets/templates/protocols/import.csv');

		if($migrate->fails()) {
			export($migrate->errors());
		}

		foreach($migrate->data() as $protocol) {

			$supplement = Supplement::where('name',$protocol['supplement'])
				->where('subscriber_id',Subscriber::current()->id);

			$client = Client::where('email',$protocol['client'])
				->where('subscriber_id',Subscriber::current()->id);

			if($supplement->count() && $client->count()) {
				$values = array(
					'supplement_id'=>$supplement->first()->id,
					'client_id'=>$client->first()->id
				);

				Protocol::firstOrCreate($values);
			}

		}

	});

	Route::get('/schedules',function() {

		$path = public_path().'/assets/imports/'.Subscriber::current()->subdomain.'/schedules.csv';

		$data = file_get_contents($path);

		$migrate = Migrate::import($data,public_path().'/assets/templates/schedules/import.csv');

		if($migrate->fails()) {
			export($migrate->errors());
		}

		foreach($migrate->data() as $schedule) {

			$supplement = Supplement::where('name',$schedule['supplement'])
				->where('subscriber_id',Subscriber::current()->id);

			$client = Client::where('email',$schedule['client'])
				->where('subscriber_id',Subscriber::current()->id);

			if(!$supplement->count() || !$client->count()) {
				continue;
			}

			$protocol = Protocol::where('client_id', $client->first()->id)
				->where('supplement_id', $supplement->first()->id);

			if(!$protocol->count()) {
				continue;
			}

			$scheduletime = Scheduletime::where('name',$schedule['scheduletime']);

			if(!$scheduletime->count()) {
				continue;
			}

			$values = array(
				'protocol_id'=>$protocol->first()->id,
				'scheduletime_id'=>$scheduletime->first()->id,
				'prescription'=>$schedule['prescription']
			);

			Schedule::firstOrCreate($values);

		}

	});

	Route::get('/users',function() {

		$path = public_path().'/assets/imports/'.Subscriber::current()->subdomain.'/users.csv';

		$data = file_get_contents($path);

		$migrate = Migrate::import($data,public_path().'/assets/templates/users/import.csv');

		if($migrate->fails()) {
			export($migrate->errors());
		}

		foreach($migrate->data() as $user) {

			$client = Client::where('email',$user['client'])
				->where('subscriber_id',Subscriber::current()->id);

			if(!$client->count()) {
				continue;
			}

			$values = array(
				'first_name'=>$user['first_name'],
				'last_name'=>$user['last_name'],
				'email'=>$user['email'],
				'subscriber_id'=>Subscriber::current()->id,
				'role_id'=>Role::where('name','client')->first()->id
			);

			$user = User::firstOrCreate($values);

			$client = $client->first();

			$client->user_id = $user->id;

			$client->save();

		}

	});

});