<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriberOrderSettinggroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$scope = Scope::where('name','subscriber')->pluck('id');

		$group = Settinggroup::create([
			'scope_id'=>$scope,
			'name'=>'orders'
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$scope = Scope::where('name','subscriber')->pluck('id');

		$group = Settinggroup::where('scope_id',$scope)
			->where('name','orders')
			->delete();
	}

}
