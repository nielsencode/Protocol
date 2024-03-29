<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Client extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Client::where('subscriber_id',$owner)->lists('id');
	}

	public function scopeClient($owner) {
		return array($owner);
	}

	public function scopeProtocol() {
		return \Client::lists('id');
	}

}