<?php

use Carbon\Carbon as Carbon;

class SupplementController extends BaseController {

	public function getIndex() {
		Auth::user()
			->requires('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		$supplements = Supplement::where('subscriber_id',Subscriber::current()->id);

		if(Input::get('q')) {
			$supplements = $supplements->where('fulltext','LIKE','%'.Input::get('q').'%');
		}

		if(Input::get('sortby')) {
			$supplements = $supplements->orderBy(Input::get('sortby'),Input::get('order'));
		}
		else {
			$supplements = $supplements->orderBy('name','asc');
		}

		$data['supplements'] = $supplements->paginate(15);

		return View::make('supplements.index',$data);
	}

	public function getSupplement($supplement) {
		Auth::user()
			->requires('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement',$supplement->id);

		return View::make('supplements.supplement',array('supplement'=>$supplement));
	}

	public function getAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		return View::make('supplements.add');
	}

	public function postAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		$rules = array(
			'name'=>'required|unique:supplements,name',
			'price'=>'required|numeric',
			'short_description'=>'max:150'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to('supplements/add')->withErrors($validator)->withInput();
		}

		$input = Input::all();
		$input['subscriber_id'] = Subscriber::current()->id;

		$supplement = Supplement::create($input);

		return Redirect::route('supplement',array($supplement->id));
	}

	public function getEdit($supplement) {
		Auth::user()
			->requires('edit')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement',$supplement->id);

		$supplementData = $supplement->toArray();

		return View::make('supplements.edit')->with('supplement',$supplementData);
	}

	public function postEdit($supplement) {
		Auth::user()
			->requires('edit')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement',$supplement->id);

		$rules = array(
			'name'=>"required|unique:supplements,name,$supplement->id",
			'price'=>'required|numeric',
			'short_description'=>'max:150'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to("supplements/$id/edit")->withErrors($validator)->withInput();
		}

		foreach(Input::except('_token') as $k=>$v) {
			$supplement->$k = $v;
		}
		$supplement->save();

		return Redirect::route('supplement',array($supplement->id));
	}

	public function postDelete($supplement) {
		Auth::user()
			->requires('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement',$supplement->id);

		$supplement->delete();
		return Redirect::to('supplements');
	}

	public function getOrder($supplement) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->orScope('Client')
			->over('Order');

		return View::make('supplements.order')->with('supplement',$supplement);
	}

	public function postOrder($supplement) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->orScope('Client')
			->over('Order');

		$rules = array(
			'quantity'=>"required|numeric|min:1",
			'recurring_order'=>'numeric'
		);

		if(Input::has('recurring_order')) {
			$rules = array_merge($rules,array(
				'autoshipfrequency_id'=>'required|numeric'
			));
		}

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to("/supplements/{$supplement->id}/order")->withErrors($validator)->withInput();
		}

		$order = Order::create(array(
			'client_id'=>Auth::user()->client->id,
			'supplement_id'=>$supplement->id,
			'quantity'=>Input::get('quantity'),
			'date'=>new Carbon
		));

		if(Input::has('recurring_order')) {
			$now = new Carbon;
			$starting_at = $now;

			$autoship = Autoship::create(array(
				'autoshipfrequency_id' => Input::get('autoshipfrequency_id'),
				'starting_at' => $starting_at->format('Y-m-d')
			));

			$order->autoship_id = $autoship->id;
			$order->date = $starting_at;
			$order->save();
		}

		return Redirect::to("/supplements/{$supplement->id}/order")->with('success',1);
	}

	public function getExport() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		$supplements = Subscriber::current()->supplements;

		foreach($supplements as $supplement) {
			$data[] = array(
				'name'=>$supplement->name,
				'price'=>$supplement->price,
				'short description'=>$supplement->short_description,
				'description'=>$supplement->description
			);
		}

		Migrate::export($data,'supplements');
	}

	public function getImportTemplate() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		$template_path = public_path().'/assets/templates/supplements/import.csv';

		Migrate::template($template_path,'supplements-import-template');
	}

	public function getImport() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		return View::make('supplements.import');
	}

	public function postImport() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Supplement');

		$data = file_get_contents($_FILES['data']['tmp_name']);

		$template_path = public_path().'/assets/templates/supplements/import.csv';

		$migrate = Migrate::import($data,$template_path);

		if($migrate->fails()) {
			return Redirect::route('import supplements')->with('errors',$migrate->errors());
		}

		foreach($migrate->data() as $supplement) {
			if(!Supplement::where('name',$supplement['name'])->count()) {
				Supplement::create(array(
					'subscriber_id'=>Subscriber::current()->id,
					'name'=>$supplement['name'],
					'price'=>$supplement['price'],
					'description'=>$supplement['description'],
					'short_description'=>$supplement['short description']
				));
			}
		}

		return Redirect::route('import supplements')->with('success','Your supplements have been imported successfully.');
	}
}