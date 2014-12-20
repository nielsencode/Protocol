<?php namespace rbac;

use Nielsen\Rbac\Resource\ResourceScope;
use Nielsen\Rbac\Permission\Parts\Agent;

class Scope extends ResourceScope
{

	public function subscriber($user,$owner) {
		return \User::where('id',$user->id)->pluck('subscriber_id')==$owner;
	}

	public function client($user,$owner) {
		return \Client::where('user_id',$user->id)->pluck('id')==$owner;
	}

	public function protocol($user,$owner) {
		return \User::find($user->id)->role->name=='protocol';
	}

}