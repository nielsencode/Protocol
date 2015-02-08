<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnnouncementBarSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$group = Settinggroup::where('name','appearance')
			->where('scope_id',Scope::where('name','subscriber')->pluck('id'))
			->pluck('id');

		$input = Inputtype::where('name','checkbox')->pluck('id');

		Settingname::create([
			'inputtype_id'=>$input,
			'settinggroup_id'=>$group,
			'name'=>'show announcement bar',
			'default'=>0,
			'description'=>'Show announcement bar above the header.'
		]);

		$input = Inputtype::where('name','text')->pluck('id');

		Settingname::create([
			'inputtype_id'=>$input,
			'settinggroup_id'=>$group,
			'name'=>'announcement bar',
			'description'=>'Text to display in announcement bar. 115 characters max.',
			'maxlength'=>115
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$group = Settinggroup::where('name','appearance')
			->where('scope_id',Scope::where('name','subscriber')->pluck('id'))
			->pluck('id');

		$names = ['announcement bar','show announcement bar'];

		foreach($names as $name) {

			$setting = Settingname::where('name',$name)
				->where('settinggroup_id',$group);

			Setting::where('settingname_id',$setting->pluck('id'))->delete();

			$setting->delete();

		}
	}

}
