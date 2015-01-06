<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Order extends ResourceType
{

	public function scopeSubscriber($owner) {

		return \Order::join('clients','clients.id','=','orders.client_id')
			->where('clients.subscriber_id',$owner)
			->select('orders.id')
			->withTrashed()
			->lists('id');
	}

	public function scopeClient($owner) {
		return \Order::where('client_id',$owner)->withTrashed()->lists('id');
	}

	public function scopeProtocol() {
		return \Order::lists('id');
	}

}