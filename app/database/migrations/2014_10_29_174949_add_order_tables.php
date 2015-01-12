<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders',function($table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('supplement_id')->unsigned();
			$table->smallInteger('quantity')->unsigned();
			$table->timestamp('fulfilled_at')->nullable();
			$table->integer('autoship_id')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('autoships',function($table) {
			$table->increments('id');
			$table->integer('autoshipfrequency_id')->unsigned();
			$table->timestamp('starting_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('autoshipfrequencies',function($table) {
			$table->increments('id');
			$table->string('name',50);
		});

		Schema::table('orders',function($table) {
			$table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('supplement_id')->references('id')->on('supplements')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('autoship_id')->references('id')->on('autoships')->onUpdate('cascade')->onDelete('set null');
		});

		Schema::table('autoships',function($table) {
			$table->foreign('autoshipfrequency_id')->references('id')->on('autoshipfrequencies')->onUpdate('cascade')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
		Schema::drop('autoships');
		Schema::drop('autoshipfrequencies');
	}

}
