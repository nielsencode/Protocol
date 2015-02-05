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

		export(Input::all());

		$input = Input::except('_token');

		$rules = array(
			'logo'=>'max:2000|image',
			'external_store'=>'url'
		);

		$validator = Validator::make($input,$rules);

		if($validator->fails()) {
			return Redirect::route('settings')->withErrors($validator)->withInput();
		}

		if(Input::hasFile('logo')) {
			$dest = public_path().'/assets/uploads';

			$name = uniqid().".png";

			$image = Image::make(Input::file('logo'))->encode('png');

			$image->save($dest."/$name");

			$input['logo'] = url("images/$name");
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

		return Redirect::route('settings')->with('success','Your settings have been saved.');
	}

}