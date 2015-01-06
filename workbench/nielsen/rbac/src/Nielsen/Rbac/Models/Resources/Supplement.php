<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Supplement extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Supplement::where('subscriber_id',$owner)->lists('id');
	}

	public function scopeProtocol() {
		return \Supplement::lists('id');
	}

}