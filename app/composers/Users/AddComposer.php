<?php namespace myUsers;

class AddComposer {

	public function compose($view) {
		$roles = \Role::where('name','admin')->lists('name','id');

		$data = array(
			'roles'=>$roles
		);

		$view->with($data);
	}
}