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
		$group = Settinggroup::where('name','orders')
			->where('scope_id',Scope::where('name','subscriber')->pluck('id'))
			->pluck('id');

		Settingname::create([
			'inputtype_id'=>Inputtype::where('name','checkbox')->pluck('id'),
			'settinggroup_id'=>$group,
			'name'=>'enable orders',
			'default'=>1,
			'description'=>'let clients place supplement orders through protocol.'
		]);

		Settingname::create([
			'inputtype_id'=>Inputtype::where('name','text')->pluck('id'),
			'settinggroup_id'=>$group,
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
		$group = Settinggroup::where('name','orders')
			->where('scope_id',Scope::where('name','subscriber')->pluck('id'))
			->pluck('id');

		$settingnames = Settingname::where('settinggroup_id',$group)
			->whereIn('name',['enable orders','external store']);

		Setting::whereIn('settingname_id',$settingnames->lists('id'))
			->delete();

		$settingnames->delete();
	}

}
