<?php namespace Nielsen\Rbac\Models\Resources;

use Nielsen\Rbac\Resource\ResourceType;

class Autoship extends ResourceType
{

	public function scopeSubscriber($owner) {
		return \Autoship::select('autoships.id')
			->join('orders','orders.autoship_id','=','autoships.id')
			->join('clients','clients.id','=','orders.client_id')
			->join('subscribers','subscriber.id','=','clients.subscriber_id')
			->where('subscribers.id',$owner)
			->lists('autoships.id');
	}

	public function scopeClient($owner) {
		return \Autoship::select('autoships.id')
			->join('orders','orders.autoship_id','=','autoships.id')
			->join('clients','clients.id','=','orders.client_id')
			->where('clients.id',$owner)
			->lists('autoships.id');
	}

	public function scopeProtocol() {
		return \Autoship::lists('id');
	}

}