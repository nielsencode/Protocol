<?php

use Illuminate\Database\Migrations\Migration;

class AllTablesUp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users',function($table) {
			$table->increments('id');
			$table->integer('role_id')->unsigned();
			$table->integer('subscriber_id')->unsigned()->nullable();
			$table->string('email')->unique();
			$table->string('password',100)->nullable();
			$table->string('first_name',100)->nullable();
			$table->string('last_name',100)->nullable();
			$table->integer('token_id')->unsigned()->nullable();
			$table->string('remember_token',100)->nullable();
			$table->text('fulltext')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('roles',function($table) {
			$table->increments('id');
			$table->string('name')->unique();
		});

		Schema::create('scopes',function($table) {
			$table->increments('id');
			$table->string('name');
		});

		Schema::create('permissions',function($table) {
			$table->increments('id');
			$table->string('agent_type',100);
			$table->integer('agent_id')->unsigned();
			$table->string('resource_type',100);
			$table->integer('resource_id')->unsigned()->nullable();
			$table->integer('scope_id')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('actions',function($table) {
			$table->increments('id');
			$table->string('name',100)->unique();
		});

		Schema::create('action_permission',function($table) {
			$table->integer('action_id')->unsigned();
			$table->integer('permission_id')->unsigned();
		});
		
		Schema::create('addresses',function($table) {
			$table->increments('id');
			$table->integer('addressable_id')->unsigned();
			$table->string('addressable_type',100);
			$table->integer('addresstype_id')->unsigned();
			$table->text('address');
			$table->text('city');
			$table->text('state');
			$table->string('zip',50);
			$table->string('phone',10)->nullable();
			$table->timestamps();
		});
		
		Schema::create('addresstypes',function($table) {
			$table->increments('id');
			$table->string('name',100);
		});
		
		Schema::create('emails',function($table) {
			$table->increments('id');
			$table->integer('emailable_id')->unsigned();
			$table->string('emailable_type',100);
			$table->text('message');
			$table->timestamps();
		});
		
		Schema::create('subscribers',function($table) {
			$table->increments('id');
			$table->string('name',100);
			$table->string('email');
			$table->string('subdomain',100)->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('clients',function($table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('subscriber_id')->unsigned();
			$table->string('first_name',100);
			$table->string('last_name',100);
			$table->string('email')->unique();
			$table->text('fulltext')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('tokens',function($table) {
			$table->increments('id');
			$table->text('token');
			$table->integer('expires_at');
			$table->timestamps();
		});
		
		Schema::create('supplements',function($table) {
			$table->increments('id');
			$table->integer('subscriber_id')->unsigned();
			$table->string('name',100);
			$table->text('description')->nullable();
			$table->text('short_description')->nullable();
			$table->decimal('price',5,2);
			$table->text('fulltext')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
		
		Schema::create('protocols',function($table) {
			$table->increments('id');
			$table->integer('supplement_id')->unsigned();
			$table->integer('client_id')->unsigned();
			$table->timestamps();
		});
		
		Schema::create('schedules',function($table) {
			$table->increments('id');
			$table->integer('protocol_id')->unsigned();
			$table->integer('scheduletime_id')->unsigned();
			$table->text('prescription');
			$table->timestamps();
		});
		
		Schema::create('scheduletimes',function($table) {
			$table->increments('id');
			$table->integer('index');
			$table->string('name',100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('roles');
		Schema::drop('actions');
		Schema::drop('permissions');
		Schema::drop('action_permission');
		Schema::drop('scopes');
		Schema::drop('addresses');
		Schema::drop('addresstypes');
		Schema::drop('emails');
		Schema::drop('subscribers');
		Schema::drop('clients');
		Schema::drop('tokens');
		Schema::drop('supplements');
		Schema::drop('protocols');
		Schema::drop('schedules');
		Schema::drop('scheduletimes');
	}

}