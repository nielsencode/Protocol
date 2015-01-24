<?php namespace Nielsen\Rbac\Models;

use Nielsen\Rbac\Resource\ResourceScope;

class Scope extends ResourceScope
{

	public function subscriber($user,$owner) {
		return \Subscriber::where('id',$owner)
			->first()
			->users()
			->where('id',$user->id)
			->count();
	}

	public function client($user,$owner) {
		return \Client::where('user_id',$user->id)->pluck('id')==$owner;
	}

	public function protocol($user) {
		return \User::find($user->id)->role->name=='protocol';
	}

}