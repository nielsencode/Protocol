<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscriberSubdomainNotNullUnique extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = "
			ALTER TABLE `subscribers`
			CHANGE COLUMN `subdomain`
			`subdomain` VARCHAR(100) NOT NULL DEFAULT '';
		";

		DB::statement(preg_replace('/\s+/',' ',$sql));

		Schema::table('subscribers',function($table) {
			$table->unique('subdomain');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscribers',function($table) {
			$table->dropUnique('subscribers_subdomain_unique');
		});

		$sql = "
			ALTER TABLE `subscribers`
			CHANGE COLUMN `subdomain`
			`subdomain` VARCHAR(100) NULL DEFAULT NULL;
		";

		DB::statement(preg_replace('/\s+/',' ',$sql));
	}

}
