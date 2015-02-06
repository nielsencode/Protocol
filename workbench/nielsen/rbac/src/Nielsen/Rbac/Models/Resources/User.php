<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class User extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \User::join('subscriber_user','subscriber_user.user_id','=','users.id')
			->where('subscriber_user.subscriber_id',$owner)
			->lists('id');
	}

	public function scopeClient($owner) {
		return \Client::where('id',$owner)->lists('user_id');
	}

	public function scopeProtocol() {
		return \User::lists('id');
	}

}