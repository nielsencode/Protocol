<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscriberUserForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscriber_user',function($table) {

			$table
				->foreign('subscriber_id')
				->references('id')
				->on('subscribers')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table
				->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscriber_user',function($table) {

			$table->dropForeign('subscriber_user_user_id_foreign');
			$table->dropForeign('subscriber_user_subscriber_id_foreign');

		});
	}

}
