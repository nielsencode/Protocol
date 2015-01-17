<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProtocolsToDemoSubscriberClients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$subscriber = Subscriber::where('subdomain','demo')->first();

		$supplements = $subscriber->supplements->toArray();

		foreach($subscriber->clients as $client) {

			shuffle($supplements);

			$prescriptions = Seed::data('prescriptions')->get();

			for ($i = 0; $i<rand(3,20); $i++) {
				$protocol = Protocol::create(array(
					'client_id' => $client->id,
					'supplement_id' => $supplements[$i]['id']
				));

				foreach (Scheduletime::all() as $scheduletime) {
					if (rand(0, 1)) {
						shuffle($prescriptions);
						Schedule::create(array(
							'scheduletime_id' => $scheduletime->id,
							'prescription' => $prescriptions[0],
							'protocol_id' => $protocol->id
						));
					}
				}
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
			$client->protocols()->delete();
		}
	}

}
