<?php namespace myUsers;

class AddComposer {

	public function compose($view) {
		switch(\Auth::user()->role->name) {
			case 'protocol':
				$roleNames = array('subscriber','admin','client');
				break;
			case 'subscriber':
				$roleNames = array('admin','client');
				break;
		}

		$roles = \Role::whereIn('name',$roleNames)->lists('name','id');

		$data = array(
			'roles'=>$roles
		);

		$view->with($data);
	}
}