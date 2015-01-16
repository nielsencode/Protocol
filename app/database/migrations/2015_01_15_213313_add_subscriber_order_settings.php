<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriberOrderSettings extends Migration {

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

		$inputtype = Inputtype::create([
			'name'=>'checkbox'
		]);

		Settingname::create([
			'inputtype_id'=>$inputtype->id,
			'settinggroup_id'=>$group->id,
			'name'=>'enable orders',
			'default'=>1
		]);

		Settingname::create([
			'inputtype_id'=>Inputtype::where('name','text')->pluck('id'),
			'settinggroup_id'=>$group->id,
			'name'=>'external store',
			'description'=>'link to an external store when orders are disabled.'
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
			->first();

		Settingname::where('settinggroup_id',$group->id)->delete();

		Inputtype::where('name','checkbox')->delete();

		$group->delete();
	}

}
