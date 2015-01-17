<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientsToDemoSubscriber extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$subscriber = Subscriber::where('subdomain','demo')->first();

		$clients = 0;

		while ($clients < 100) {
			$client = array(
				'subscriber_id' => $subscriber->id,
				'first_name' => ucfirst(Seed::data('firstnames')->shuffle()->get()[0]),
				'last_name' => ucfirst(Seed::data('lastnames')->shuffle()->get()[0]),
				'email' => uniqid() . '@mailinator.com'
			);

			if(!Client::where('email', $client['email'])->count()) {
				Client::create($client);
				$clients++;
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

		$subscriber->clients()->delete();
	}

}
