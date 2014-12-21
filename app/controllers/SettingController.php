<?php

class SettingController extends BaseController {

	public function getIndex() {
		Auth::user()
			->requires('edit')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Setting');

		return View::make('settings.index');
	}

	public function postIndex() {
		Auth::user()
			->requires('edit')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Setting');

		$input = Input::except('_token');

		$rules = array(
			'logo'=>'max:2000|image'
		);

		$validator = Validator::make($input,$rules);

		if($validator->fails()) {
			return Redirect::route('settings')->withErrors($validator)->withInput();
		}

		if(Input::hasFile('logo')) {
			$dest = public_path().'/assets/uploads';
			$ext = Input::file('logo')->getClientOriginalExtension();
			$name = uniqid().".$ext";

			Input::file('logo')->move($dest,$name);

			$input['logo'] = url("uploads/$name");
		}

		foreach($input as $k=>$value) {
			$setting = Setting::firstOrCreate(array(
				'settingable_type'=>'Subscriber',
				'settingable_id'=>Subscriber::current()->id,
				'settingname_id'=>Settingname::where('name',str_replace('_',' ',$k))->pluck('id')
			));

			$setting->value = $value;

			$setting->save();
		}

		return Redirect::route('settings');
	}

}