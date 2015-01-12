<?php

use Illuminate\Database\Migrations\Migration;

class AllTablesForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function($table) {
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('token_id')->references('id')->on('tokens')->onDelete('set null')->onUpdate('cascade');
		});

		Schema::table('action_permission',function($table) {
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::table('permissions',function($table) {
			$table->foreign('scope_id')->references('id')->on('scopes')->onDelete('restrict')->onUpdate('cascade');
		});
		
		Schema::table('addresses',function($table) {
			$table->foreign('addresstype_id')->references('id')->on('addresstypes')->onDelete('restrict')->onUpdate('cascade');
		});
		
		Schema::table('clients',function($table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade')->onUpdate('cascade');
		});
		
		Schema::table('protocols',function($table) {
			$table->foreign('supplement_id')->references('id')->on('supplements')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
		});

		Schema::table('supplements',function($table) {
			$table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade')->onUpdate('cascade');
		});
		
		Schema::table('schedules',function($table) {
			$table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('scheduletime_id')->references('id')->on('scheduletimes')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('schedules',function($table) {
			$table->dropForeign('schedules_protocol_id_foreign');
			$table->dropForeign('schedules_scheduletime_id_foreign');
		});

		Schema::table('supplements',function($table) {
			$table->dropForeign('supplements_subscriber_id_foreign');
		});

		Schema::table('protocols',function($table) {
			$table->dropForeign('protocols_supplement_id_foreign');
			$table->dropForeign('protocols_client_id_foreign');
		});

		Schema::table('clients',function($table) {
			$table->dropForeign('clients_user_id_foreign');
			$table->dropForeign('clients_subscriber_id_foreign');
		});

		Schema::table('addresses',function($table) {
			$table->dropForeign('addresses_addresstype_id_foreign');
		});

		Schema::table('permissions',function($table) {
			$table->dropForeign('permissions_scope_id_foreign');
		});

		Schema::table('action_permission',function($table) {
			$table->dropForeign('action_permission_permission_id_foreign');
			$table->dropForeign('action_permission_action_id_foreign');
		});

		Schema::table('users',function($table) {
			$table->dropForeign('users_role_id_foreign');
			$table->dropForeign('users_subscriber_id_foreign');
			$table->dropForeign('users_token_id_foreign');
		});
	}

}