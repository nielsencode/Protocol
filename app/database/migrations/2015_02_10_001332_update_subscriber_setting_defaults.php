<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriberSettingDefaults extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$settings = [
			[
				'name'=>'enable orders',
				'default'=>0
			],
			[
				'name'=>'protocol table orientation',
				'default'=>'portrait'
			]
		];

		foreach($settings as $values) {
			$setting = Settingname::where('name',$values['name'])->first();
			$setting->default = $values['default'];
			$setting->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$settings = [
			[
				'name'=>'enable orders',
				'default'=>1
			],
			[
				'name'=>'protocol table orientation',
				'default'=>'landscape'
			]
		];

		foreach($settings as $values) {
			$setting = Settingname::where('name',$values['name'])->first();
			$setting->default = $values['default'];
			$setting->save();
		}
	}

}
