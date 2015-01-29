<?php

function migrate($type,$callback)
{

	$path = app_path() . '/imports/' . Subscriber::current()->subdomain . '/'.$type.'.csv';

	$data = file_get_contents($path);

	$migrate = Migrate::import($data, app_path() . '/imports/templates/'.$type.'.csv');

	if ($migrate->fails()) {
		export($migrate->errors());
	}

	foreach ($migrate->data() as $datum) {
		$callback($datum);
	}

}

if(Auth::user() && Auth::user()->role->name=='protocol') {

	Route::group(['prefix' => 'import'], function () {

		Route::get('/protocols', function () {

			migrate('protocols',function($protocol) {

				$supplement = Supplement::where('name',$protocol['supplement name'])
					->where('subscriber_id', Subscriber::current()->id);

				$client = Client::where('first_name',$protocol['client first name'])
					->where('last_name',$protocol['client last name'])
					->where('subscriber_id', Subscriber::current()->id);

				if ($supplement->count() && $client->count()) {
					$values = array(
						'supplement_id' => $supplement->first()->id,
						'client_id' => $client->first()->id
					);

					Protocol::firstOrCreate($values);
				}

			});

		});

		Route::get('/schedules', function () {

			migrate('schedules',function($schedule) {

				$supplement = Supplement::where('name', $schedule['supplement name'])
					->where('subscriber_id', Subscriber::current()->id);

				$client = Client::where('first_name',$schedule['client first name'])
					->where('last_name',$schedule['client last name'])
					->where('subscriber_id', Subscriber::current()->id);

				if (!$supplement->count() || !$client->count()) {
					return;
				}

				$protocol = Protocol::where('client_id', $client->first()->id)
					->where('supplement_id', $supplement->first()->id);

				if (!$protocol->count()) {
					return;
				}

				$scheduletime = Scheduletime::where('name', $schedule['scheduletime name']);

				if (!$scheduletime->count()) {
					return;
				}

				$values = array(
					'protocol_id' => $protocol->first()->id,
					'scheduletime_id' => $scheduletime->first()->id,
					'prescription' => $schedule['prescription']
				);

				Schedule::firstOrCreate($values);

			});

		});

		Route::get('/users', function () {

			migrate('users',function($user) {

				$client = Client::where('first_name',$user['client first name'])
					->where('last_name',$user['client last name'])
					->where('subscriber_id', Subscriber::current()->id);

				if (!$client->count()) {
					return;
				}

				$values = array(
					'first_name' => $user['first name'],
					'last_name' => $user['last name'],
					'email' => $user['email'],
					'role_id' => Role::where('name', 'client')->first()->id
				);

				$user = User::where('email',$values['email']);

				if($user->count()) {
					$user = $user->first();
				}
				else {
					$user = User::create($values);
				}

				$user->subscribers()->attach(Subscriber::current()->id);

				$client = $client->first();

				$client->user_id = $user->id;

				$client->save();

			});

		});

		Route::get('/orders',function() {

			migrate('orders',function($order) {

				$client = Subscriber::current()
					->clients()
					->where('first_name',$order['client first name'])
					->where('last_name',$order['client last name']);

				$supplement = Subscriber::current()
					->supplements()
					->where('name',$order['supplement name']);

				$autoshipFrequency = Autoshipfrequency::where('name',$order['frequency']);

				if(!$client->count()) {
					return;
				}

				if(!$supplement->count()) {
					return;
				}

				if($autoshipFrequency->count()) {
					$autoship = Autoship::create([
						'autoshipfrequency_id'=>$autoshipFrequency->pluck('id'),
						'starting_at'=>$order['date']
					]);
				}

				Order::create([
					'client_id'=>$client->pluck('id'),
					'supplement_id'=>$supplement->pluck('id'),
					'quantity'=>$order['quantity'],
					'date'=>$order['date'],
					'autoship_id'=>isset($autoship) ? $autoship->id : null
				]);

			});

		});

	});

}