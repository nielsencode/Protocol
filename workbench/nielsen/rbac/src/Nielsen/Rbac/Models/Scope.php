<?php namespace Nielsen\Rbac\Models;

use Nielsen\Rbac\Resource\ResourceScope;

class Scope extends ResourceScope
{

	public function subscriber($user,$owner) {
		return \User::where('id',$user->id)->pluck('subscriber_id')==$owner;
	}

	public function client($user,$owner) {
		return \Client::where('user_id',$user->id)->pluck('id')==$owner;
	}

	public function protocol($user) {
		return \User::find($user->id)->role->name=='protocol';
	}

}