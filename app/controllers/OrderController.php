<?php

class OrderController extends BaseController {

    public function getIndex() {
        $user = Auth::user();

        $user
            ->requires('read')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Client')
            ->orScope('Protocol')
            ->over('Order');

        if($user->role->name=='client') {
            $orders = $user->client->orders()->withTrashed();
        } else {
            $orders = Subscriber::current()->orders()->withTrashed();
        }

        $orders = $orders->join('supplements','orders.supplement_id','=','supplements.id');

        $count = $orders->count();

        if(Input::get('q')) {
            $orders = $orders->where('orders.fulltext','LIKE','%'.Input::get('q').'%');
        }

        if(Input::get('sortby')) {
            $orders = $orders->orderBy(Input::get('sortby'),Input::get('order'));
        }
        else {
            $orders = $orders->orderBy('orders.created_at','desc');
        }

        $page = Input::has('page') ? Input::get('page') : 1;
        $perPage = 15;

        $orders->skip(($page-1)*$perPage)->take($perPage);
        $orders->select(array('orders.*','supplements.name AS supplement_name'));

        $data['orders'] = Paginator::make($orders->get()->all(),$count,$perPage);

        return View::make('orders.index',$data);
    }

    public function getOrder($order) {
        Auth::user()
            ->requires('read')
            ->ofScope('Client',$order->client->id)
            ->orScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Order',$order->id);

        return View::make('orders.order',array('order'=>$order));
    }

    public function postFulfill($order) {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Order',$order->id);

        $order->fulfilled_at = date('Y-m-d H:i:s',time());
        $order->save();

        return Redirect::route('order',array($order->id));
    }

    public function getEdit($order) {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->over('Order',$order->id);

        return View::make('orders.edit',array('order'=>$order));
    }

    public function postCancelRecurring($order) {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Protocol')
            ->orScope('Client',$order->client->id)
            ->over('Order',$order->id);

        $order->autoship->delete();

        return Redirect::route('order',array($order->id));
    }

    public function postDelete($order) {
        Auth::user()
            ->requires('delete')
            ->ofScope('Subscriber',Subscriber::current()->id)
            ->orScope('Client',$order->client->id)
            ->orScope('Protocol')
            ->over('Order',$order->id);

        $order->delete();

        return Redirect::route('orders');
    }

    public function postBulkEdit() {
        Auth::user()
            ->requires('edit')
            ->ofScope('Subscriber')
            ->orScope('Protocol')
            ->over('Order');

        switch(Input::get('method')) {
            case 'fulfill':
                return $this->bulkFulfillOrders();
                break;
        }
    }

    public function bulkFulfillOrders() {
        foreach(Input::get('orders') as $id) {
            $order = Order::find($id);

            $order->fulfilled_at = date('Y-m-d H:i:s',time());

            $order->save();
        }

        return Redirect::back();
    }
}