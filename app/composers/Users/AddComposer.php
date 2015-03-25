<?php namespace myUsers;

class AddComposer {

	public function compose($view) {

		$user = \Auth::user();

		if (
			$user
				->has('add')
				->ofScope('subscriber',\Subscriber::current()->id)
				->orScope('protocol')
				->over('User')
		) {

			switch ($user->role->name) {
				case 'protocol':
					$roleNames = array('subscriber', 'admin');
					break;
				case 'subscriber':
					$roleNames = array('admin');
					break;
			}

			$roles = \Role::whereIn('name', $roleNames)->lists('name', 'id');

			$data = array(
				'roles' => $roles
			);

			$view->with($data);

		}
	}
}