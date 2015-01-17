<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriberUserToDemoSubscriber extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		User::create([
			'role_id'=>Role::where('name','subscriber')->pluck('id'),
			'subscriber_id'=>Subscriber::where('subdomain','demo')->pluck('id'),
			'email'=>'demo@protocolapp.com',
			'password'=>'demopass',
			'first_name'=>'Demo',
			'last_name'=>'Subscriber'
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		User::where('email','demo@protocolapp.com')->withTrashed()->forceDelete();
	}

}
