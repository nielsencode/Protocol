<?php namespace Rbac\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class User extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \User::where('subscriber_id',$owner)->lists('id');
	}

	public function scopeClient($owner) {
		return \Client::where('id',$owner)->lists('user_id');
	}

	public function scopeProtocol($owner) {
		return \User::lists('id');
	}

}