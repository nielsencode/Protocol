<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProtocolOrientationSetting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$group = Settinggroup::create([
			'scope_id'=>Scope::where('name','subscriber')->pluck('id'),
			'name'=>'protocols'
		]);

		$input = Inputtype::create([
			'name'=>'dropdown'
		]);

		$setting = Settingname::create([
			'inputtype_id'=>$input->id,
			'settinggroup_id'=>$group->id,
			'name'=>'protocol table orientation',
			'values'=>'landscape,portrait',
			'default'=>'landscape'
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$group = Settinggroup::where('name','protocols')
			->where('scope_id',Scope::where('name','subscriber')->pluck('id'));

		Settingname::where('name','protocol table orientation')
			->where('settinggroup_id',$group->pluck('id'))
			->delete();

		Inputtype::where('name','dropdown')
			->delete();

		$group->delete();
	}

}
