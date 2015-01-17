<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplementsToDemoSubscriber extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$subscriber = Subscriber::where('subdomain','demo')->first();

		foreach (Seed::data('supplements')->get() as $supplement) {
			$supplement['price'] = implode('', array_slice(Seed::data('numbers')->shuffle()->get(), 0, 4)) / 100;
			$supplement['subscriber_id'] = $subscriber->id;

			if (!strlen($supplement['description'])) {
				$supplement['description'] = null;
				$supplement['short_description'] = null;
			} else {
				$supplement['short_description'] = substr($supplement['description'], 0, 150);
			}

			Supplement::create($supplement);
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

		$subscriber->supplements()->delete();
	}

}
