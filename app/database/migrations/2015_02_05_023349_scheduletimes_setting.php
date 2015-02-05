<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduletimesSetting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$input = Inputtype::create([
			'name'=>'list'
		]);

		$group = Settinggroup::where('name','protocols')->pluck('id');

		$settingname = Settingname::create([
			'inputtype_id'=>$input->id,
			'settinggroup_id'=>$group,
			'name'=>'schedule times',
			'default'=>json_encode(Scheduletime::lists('name')),
			'description'=>"Times of day that will show on clients' protocol tables. Click to edit. Drag to reorder."
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Settingname::where('name','schedule times')
			->where('settinggroup_id',Settinggroup::where('name','protocols')->pluck('id'))
			->delete();

		Inputtype::where('name','list')->delete();
	}

}
