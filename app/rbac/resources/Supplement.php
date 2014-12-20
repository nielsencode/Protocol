<?php namespace Rbac\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Supplement extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Supplement::where('subscriber_id',$owner)->lists('id');
	}

	public function scopeProtocol($owner) {
		return \Supplement::lists('id');
	}

}