<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressesToDemoSubscriberClients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$subscriber = Subscriber::where('subdomain','demo')->first();

		foreach($subscriber->clients as $client) {

			foreach(Addresstype::all() as $addresstype) {

				$number = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,4));
				$street = Seed::data('streetnames')->shuffle()->get()[0];
				$suffix = Seed::data('streetsuffixes')->shuffle()->get()[0];
				$city = Seed::data('cities')->shuffle()->get()[0];
				$state = Seed::data('states')->shuffle()->get()[0]['abbreviation'];
				$zip = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,5));
				$phone = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,10));

				$data = array(
					'address'=>$number.' '.ucfirst($street).' '.ucfirst($suffix),
					'city'=>ucfirst($city),
					'state'=>$state,
					'zip'=>$zip,
					'phone'=>$phone,
					'addresstype_id'=>$addresstype->id
				);

				$address = Address::create($data);

				$client->addresses()->save($address);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$subscriber = Subscriber::where('subdomain','demo')->first();

		foreach($subscriber->clients as $client) {
			$client->addresses()->delete();
		}
	}

}
