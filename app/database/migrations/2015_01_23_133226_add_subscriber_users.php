<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriberUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach(User::where('subscriber_id','<>','NULL')->get() as $user) {
			$values[] = "({$user->subscriber_id},{$user->id})";
		}

		$sql = "
			INSERT INTO subscriber_user (subscriber_id,user_id) VALUES ".implode(',',$values)."
		";

		DB::statement($sql);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$ids = implode(',',User::where('subscriber_id','<>','NULL')->lists('id'));

		$sql = "
			DELETE FROM subscriber_user WHERE user_id IN ($ids)
		";

		DB::statement($sql);
	}

}
