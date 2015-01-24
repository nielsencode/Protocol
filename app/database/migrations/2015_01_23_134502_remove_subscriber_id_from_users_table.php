<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubscriberIdFromUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function($table) {
			$table->dropForeign('users_subscriber_id_foreign');
			$table->dropColumn('subscriber_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users',function($table) {
			$table->integer('subscriber_id')->unsigned()->nullable()->after('last_name');

			$table
				->foreign('subscriber_id')
				->references('id')
				->on('subscribers')
				->onUpdate('cascade')
				->onDelete('restrict');
		});

		$sql = "
			INSERT INTO users (subscriber_id,id)
			SELECT subscriber_id,user_id
			FROM subscriber_user
			ON DUPLICATE KEY UPDATE
			subscriber_id = VALUES(subscriber_id)
		";

		DB::statement($sql);
	}

}
