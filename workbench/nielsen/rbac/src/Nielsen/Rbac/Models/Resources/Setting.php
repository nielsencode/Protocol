<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Setting extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Subscriber::where('id',$owner)->settings()->lists('id');
	}

}