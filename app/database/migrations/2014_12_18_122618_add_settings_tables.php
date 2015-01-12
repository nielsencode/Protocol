<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inputtypes',function($table) {
			$table->increments('id');
			$table->string('name',100)->unique();
		});

		Schema::create('settinggroups',function($table) {
			$table->increments('id');
			$table->integer('scope_id')->unsigned();
			$table->string('name',100)->unique();
		});

		Schema::create('settingnames',function($table) {
			$table->increments('id');
			$table->integer('inputtype_id')->unsigned();
			$table->integer('settinggroup_id')->unsigned();
			$table->string('name',100)->unique();
			$table->text('values')->nullable();
			$table->text('description')->nullable();
			$table->text('default')->nullable();
		});

		Schema::create('settings',function($table) {
			$table->increments('id');
			$table->string('settingable_type',100);
			$table->integer('settingable_id')->unsigned();
			$table->integer('settingname_id')->unsigned();
			$table->text('value');
		});

		Schema::table('settinggroups',function($table) {
			$table->foreign('scope_id')->references('id')->on('scopes')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::table('settingnames',function($table) {
			$table->foreign('inputtype_id')->references('id')->on('inputtypes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('settinggroup_id')->references('id')->on('settinggroups')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::table('settings',function($table) {
			$table->foreign('settingname_id')->references('id')->on('settingnames')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
		Schema::drop('settingnames');
		Schema::drop('settinggroups');
		Schema::drop('inputtypes');
	}

}
