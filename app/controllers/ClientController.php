<?php

class ClientController extends BaseController {

	public function getIndex() {
		Auth::user()
			->requires('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		$clients = Client::where('subscriber_id',Subscriber::current()->id);

		if(Input::get('q')) {
			$clients = $clients->where('fulltext','LIKE','%'.Input::get('q').'%');
		}

		if(Input::get('sortby')) {
			$clients = $clients->orderBy(Input::get('sortby'),Input::get('order'));
		}
		else {
			$clients = $clients->orderBy('last_name','asc');
		}

		$data['clients'] = $clients->paginate(15);

		return View::make('clients.index',$data);
	}

	public function getClient($client) {
		Auth::user()
			->requires('read')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id);

		return View::make('clients.client',array('client'=>$client));
	}

	public function getAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		return View::make('clients.add');
	}

	public function postAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		$rules = array(
			'first_name'=>'required',
			'last_name'=>'required',
			'email'=>'required|email|unique:clients|unique:users',
		);

		$addressRules = array(
			'address'=>'required',
			'city'=>'required',
			'state'=>'required|size:2',
			'zip'=>'required',
			'phone'=>'required'
		);

		foreach(Addresstype::all() as $addresstype) {
			foreach($addressRules as $fieldName=>$rule) {
				$key = "{$addresstype->name}_$fieldName";
				if($addresstype->name!='shipping' || $fieldName!='phone') {
					$rules[$key] = $rule;
				}
			}
		}

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to('clients/add')->withErrors($validator)->withInput();
		}

		$client = Client::create(array(
			'subscriber_id'=>Subscriber::current()->id,
			'first_name'=>Input::get('first_name'),
			'last_name'=>Input::get('last_name'),
			'email'=>Input::get('email')
		));

		$inputExpanded = array();
		arrayExpand(Input::all(),$inputExpanded,'_');

		foreach(Addresstype::all() as $addresstype) {
			if($addressData = $inputExpanded[$addresstype->name]) {
				$addressData = array_merge($addressData,array(
					'addressable_id'=>$client->id,
					'addressable_type'=>'client',
					'addresstype_id'=>$addresstype->id
				));
				Address::create($addressData);
			}
		}

		return Redirect::to('clients/'.$client->id);
	}

	public function getEdit($client) {
		Auth::user()
			->requires('edit')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id);

		$clientData = $client->toArray();

		foreach($client->addresses as $address) {
			$flat = array();
			arrayFlatten($address->toArray(),$flat,'_',$address->addresstype->name);
			$clientData = array_merge($clientData,$flat);
		}

		$data = array(
			'client'=>$client,
			'clientData'=>$clientData
		);

		return View::make('clients.edit')->with($data);
	}

	public function postEdit($client) {
		Auth::user()
			->requires('edit')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id);

		$rules = array(
			'first_name'=>'required',
			'last_name'=>'required',
			'email'=>"required|email|unique:clients,email,{$client->id}",
		);

		$addressRules = array(
			'address'=>'required',
			'city'=>'required',
			'state'=>'required|size:2',
			'zip'=>'required',
			'phone'=>'required'
		);

		foreach(Addresstype::all() as $addresstype) {
			foreach($addressRules as $fieldName=>$rule) {
				$key = "{$addresstype->name}_$fieldName";
				if($addresstype->name!='shipping' || $fieldName!='phone') {
					$rules[$key] = $rule;
				}
			}
		}

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to("clients/{$client->id}/edit")->withErrors($validator)->withInput();
		}

		foreach(array('first_name','last_name','email') as $k) {
			$client->$k = Input::get($k);
		}
		$client->save();

		$inputExpanded = array();
		arrayExpand(Input::all(),$inputExpanded,'_');

		foreach(Addresstype::all() as $addresstype) {
			if($addressData = $inputExpanded[$addresstype->name]) {

				if($address = $client->addresses()->ofType($addresstype->name)->first()) {
					$address->update($addressData);
				}
				else {
					$addressData = array_merge($addressData,array(
						'addressable_id'=>$client->id,
						'addressable_type'=>'client',
						'addresstype_id'=>$addresstype->id
					));

					Address::create($addressData);
				}
			}
		}

		if(Auth::user()->role->name=='client') {
			return Redirect::route('my profile');
		}
		else {
			return Redirect::route('client',array($client->id));
		}
	}

	public function postDelete($client) {
		Auth::user()
			->requires('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id);

		$client->delete();
		return Redirect::to('clients');
	}

	public function getAddProtocol($client) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Protocol');

		return View::make('clients.protocols.add',array('client'=>$client));
	}

	public function postAddProtocol($client) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Protocol');

		$input = array();
		arrayExpand(Input::all(), $input);

		$protocol = Protocol::create(array(
			'client_id' => $client->id,
			'supplement_id' => Input::get('supplement')
		));

		foreach ($input['schedules'] as $schedule) {
			if (isset($schedule['scheduletime_id'])) {
				Schedule::create(array(
					'protocol_id' => $protocol->id,
					'scheduletime_id' => $schedule['scheduletime_id'],
					'prescription' => $schedule['prescription']
				));
			}
		}

		return Redirect::route('client',array($client->id));
	}

	public function getPrintProtocols($client) {
		Auth::user()
			->requires('read')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Protocol');

		foreach($client->protocols as $protocol) {
			$protocols[] = $protocol;
		}

		@usort($protocols,function($a,$b) {
			if($a->supplement->name==$b->supplement->name) {return 0;}
			return $a->supplement->name<$b->supplement->name ? -1 : 1;
		});

		$pageCount = 8;

		$protocols = array_map(function($v) use ($pageCount) {
			return array_pad($v,$pageCount,null);
		},array_chunk($protocols,$pageCount));

		return View::make('clients.protocols.print',array(
			'client'=>$client,
			'protocols'=>$protocols
		));
	}

	public function getAccount($client) {
		Auth::user()
			->requires('read')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		return View::make('clients.account.account',array(
			'client'=>$client
		));
	}

	public function getAddAccount($client) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		return View::make('clients.account.add',array(
			'client'=>$client
		));
	}

	public function postAddAccount($client) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		$rules = array(
			'first_name'=>'required',
			'last_name'=>'required',
			'email'=>'required|email|unique:users'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::to("clients/{$client->id}/account/add")->withErrors($validator)->withInput();
		}

		$user = User::create(array(
			'first_name'=>Input::get('first_name'),
			'last_name'=>Input::get('last_name'),
			'email'=>Input::get('email'),
			'role_id'=>Role::where('name','client')->first()->id,
			'subscriber_id'=>Subscriber::current()->id
		));

		$client->user_id = $user->id;
		$client->save();

		self::newAccountInvitation($client);

		return Redirect::to("clients/{$client->id}/account");
	}

	public function getEditAccount($client) {
		if(!$client->user) {
			App::abort(404);
		}

		Auth::user()
			->requires('edit')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		return View::make('clients.account.edit',array(
			'client'=>$client,
			'user'=>$client->user
		));
	}

	public function postEditAccount($client) {
		Auth::user()
			->requires('edit')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		if(!Input::has('token')) {
			$rules = array(
				'first_name'=>'required',
				'last_name'=>'required',
				'email'=>"required|email|unique:users,email,{$client->user->id}",
				'password'=>'same:retype_password'
			);
		}

		if(Input::has('token')) {
			$rules = array(
				'password'=>'required|same:retype_password',
				'retype_password'=>'required'
			);
		}

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			if(Input::has('token')) {
				return Redirect::to("clients/{$client->id}/account/edit?token=".Input::get('token'))->withErrors($validator)->withInput();
			}

			return Redirect::to("clients/{$client->id}/account/edit")->withErrors($validator)->withInput();
		}

		if($token = $client->user->token) {
			$token->delete();
		}

		$input = Input::all();
		$input['token_id'] = null;

		$client->user->update(Input::all());
		Auth::login($client->user);

		if(Auth::user()->role->name=='client') {
			return Redirect::route('my account');
		}
		else {
			return Redirect::route('client account',array($client->id));
		}
	}

	public static function newAccountInvitation($client) {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		if($token = $client->user->token) {
			$token->delete();
		}

		$token = Token::create(array(
			'expires_at'=>-1
		));

		$client->user->token_id = $token->id;
		$client->user->save();

		$client->user->sendEmail('New Account',array('text'=>'auth.emails.new_account'),array(
			'subscriber'=>Subscriber::current()->name,
			'link'=>route('set password',array('token'=>$token->token))
		));
	}

	public static function getNewAccountInvitation($client) {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		self::newAccountInvitation($client);
		return Redirect::route('client account',array($client->id));
	}

	public function getImport() {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		return View::make('clients.import');
	}

	public function postImport() {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		$data = file_get_contents($_FILES['data']['tmp_name']);

		$template_path = public_path().'/assets/templates/clients/import.csv';

		$migrate = Migrate::import($data,$template_path);

		if($migrate->fails()) {
			return Redirect::route('import clients')->with('errors',$migrate->errors());
		}

		foreach(Addresstype::all() as $type) {
			$addresstypes[$type->name] = $type->id;
		}

		foreach($migrate->data() as $data) {
			$clientData = array_intersect_key($data,array_flip(array('first name','last name','email')));

			$clientData = array_combine(str_replace(' ','_',array_keys($clientData)),array_values($clientData));

			/*if(Client::where('email',$clientData['email'])->count()>0) {
				continue;
			}*/

			$clientData['subscriber_id'] = Subscriber::current()->id;

			$client = Client::firstOrCreate($clientData);

			$pattern = '/('.implode('|',array_keys($addresstypes)).') (.+)/';

			$addresses = array();

			foreach($data as $key=>$value) {

				$value = trim($value);

				if(preg_match($pattern,$key,$matches)) {

					$addresstype = $matches[1];

					$attribute = $matches[2];

					if($attribute=='state' && strlen($value)>2) {
						$value = location($value)->address_components[0]->short_name;
					}

					if(!isset($addresses[$addresstype])) {
						$addresses[$addresstype] = array(
							'addresstype_id'=>$addresstypes[$addresstype],
							'addressable_type'=>'client',
							'addressable_id'=>$client->id
						);
					}

					$addresses[$addresstype][$attribute] = $value;

					$addresses[$addresstype]['addresstype_id'] = $addresstypes[$addresstype];

				}

			}

			foreach($addresses as $address) {
				Address::firstOrCreate($address);
			}
		}

		return Redirect::route('import clients')->with('success','Your clients have been imported successfully.');
	}

	public function getImportTemplate() {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		$template_path = public_path().'/assets/templates/clients/import.csv';
		Migrate::template($template_path,'clients-import-template');
	}

	public function getExport() {
		Auth::user()
			->has('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client');

		foreach(Subscriber::current()->clients as $client) {
			$data = array(
				'first name'=>$client->first_name,
				'last name'=>$client->last_name,
				'email'=>$client->email
			);

			foreach($client->addresses as $address) {
				$type = $address->addresstype->name;
				$data = array_merge($data,array(
					$type.' address'=>$address->address,
					$type.' city'=>$address->city,
					$type.' state'=>$address->state,
					$type.' zip'=>$address->zip,
					$type.' phone'=>$address->phone
				));
			}

			$clients[] = $data;
		}

		Migrate::export($clients,'clients');
	}

	public function getOrders($client) {
		Auth::user()
			->requires('read')
			->ofScope('Client',$client->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Order');

		$orders = Order::where('client_id',$client->id);

		if(Input::get('q')) {
			$orders = $orders->where('fulltext','LIKE','%'.Input::get('q').'%');
		}

		if(Input::get('sortby')) {
			$orders = $orders->orderBy(Input::get('sortby'),Input::get('order'));
		}
		else {
			$orders = $orders->orderBy('created_at','desc');
		}

		$orders = $orders->paginate(15);

		return View::make('clients.orders.index')->with(array(
			'client'=>$client,
			'orders'=>$orders
		));
	}

	public function getLoginAs($client) {
		Auth::user()
			->requires('login')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('Client',$client->id);

		Auth::login($client->user);

		return Redirect::route('home');
	}
}