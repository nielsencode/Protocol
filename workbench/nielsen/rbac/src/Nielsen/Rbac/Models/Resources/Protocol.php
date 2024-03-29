<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Protocol extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Subscriber::find($owner)->protocols->lists('id');
	}

	public function scopeClient($owner) {
		return \Protocol::where('client_id',$owner)->lists('id');
	}

	public function scopeProtocol() {
		return \Protocol::lists('id');
	}

}