<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProtocolsSupplementIdForeignOnDeleteCascade extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('protocols',function($table) {

			$table->dropForeign('protocols_supplement_id_foreign');

			$table
				->foreign('supplement_id')
				->references('id')
				->on('supplements')
				->onDelete('cascade')
				->onUpdate('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('protocols',function($table) {

			$table->dropForeign('protocols_supplement_id_foreign');

			$table
				->foreign('supplement_id')
				->references('id')
				->on('supplements')
				->onDelete('restrict')
				->onUpdate('cascade');

		});
	}

}
