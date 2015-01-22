<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersSubscriberIdForeignOnDeleteCascade extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function($table) {
			$table->dropForeign('users_subscriber_id_foreign');
			$table->foreign('subscriber_id')->references('id')->on('subscribers')->onUpdate('cascade')->onDelete('cascade');
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
			$table->dropForeign('users_subscriber_id_foreign');
			$table->foreign('subscriber_id')->references('id')->on('subscribers')->onUpdate('cascade')->onDelete('restrict');
		});
	}

}
