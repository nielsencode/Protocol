<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompositeUniqueEmailAndSubscriberIdForClients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clients',function($table) {
			$table->dropUnique('clients_email_unique');
			$table->unique(['email','subscriber_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clients',function($table) {
			$table->dropUnique('clients_email_subscriber_id_unique');
			$table->unique('email');
		});
	}

}
