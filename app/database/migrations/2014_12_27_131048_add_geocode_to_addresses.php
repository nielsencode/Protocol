<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeocodeToAddresses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addresses',function($table) {
			$table->decimal('latitude',10,8)->nullable();
			$table->decimal('longitude',11,8)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('addresses',function($table) {
			$table->dropColumn('latitude');
			$table->dropColumn('longitude');
		});
	}

}
