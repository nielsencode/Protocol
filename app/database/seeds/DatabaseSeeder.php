<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::disableQueryLog();

		Eloquent::unguard();

		$this->call('RoleSeeder');
		$this->call('ActionSeeder');
		$this->call('ScopeSeeder');
		$this->call('PermissionSeeder');
		$this->call('SubscriberSeeder');
		$this->call('ClientSeeder');
		$this->call('UserSeeder');
		$this->call('AddresstypeSeeder');
		$this->call('AddressSeeder');
		$this->call('ScheduletimeSeeder');
		$this->call('SupplementSeeder');
		$this->call('ProtocolSeeder');
		$this->call('AutoshipfrequencySeeder');
		$this->call('InputtypeSeeder');
		$this->call('SettinggroupSeeder');
		$this->call('SettingnameSeeder');
	}
}


class RoleSeeder extends Seeder {

	public function run() {
		DB::table('roles')->delete();

		$roles = array('protocol','subscriber','admin','client');

		foreach($roles as $role) {
			Role::create(array('name'=>$role));
		}
	}

}


class ActionSeeder extends Seeder {

	public function run() {
		DB::table('actions')->delete();
		$actions = array(
			'read',
			'edit',
			'add',
			'delete',
			'login'
		);
		foreach($actions as $action) {
			Action::create(array(
				'name'=>$action
			));
		}
	}
}


class ScopeSeeder extends Seeder {

	public function run() {
		DB::table('scopes')->delete();

		$scopes = array(
			'Subscriber',
			'Client',
			'User',
			'Protocol'
		);

		foreach($scopes as $scope) {
			Scope::create(array('name'=>$scope));
		}
	}
}


class PermissionSeeder extends Seeder {

	public function run() {
		DB::table('permissions')->delete();

		Artisan::call('rbac:load',array('path'=>'app/rbac/permissions/base.php'));
	}
}


class SubscriberSeeder extends Seeder {

	public function run() {
		DB::table('subscribers')->delete();
		$subs = array(
			array(
				'name'=>'Wonky Woo',
				'subdomain'=>'wonkywoo',
				'email'=>'woo@wonkywoo.com'
			)
		);
		foreach($subs as $sub) {
			Subscriber::create($sub);
		}
	}

}


class UserSeeder extends Seeder {

	public function run() {
		DB::table('users')->delete();

		$nick = User::create(array(
			'role_id' => Role::where('name', 'protocol')->first()->id,
			'email' => 'nick@nicknielsencode.com',
			'password' => 'Portent1',
			'first_name' => 'Nick',
			'last_name' => 'Nielsen'
		));
	}

}


class ClientSeeder extends Seeder {

	public function run() {
		DB::table('clients')->delete();

		foreach(Subscriber::all() as $subscriber) {

			$clients = 0;

			while ($clients < 100) {
				$client = array(
					'subscriber_id' => $subscriber->id,
					'first_name' => ucfirst(Seed::data('firstnames')->shuffle()->get()[0]),
					'last_name' => ucfirst(Seed::data('lastnames')->shuffle()->get()[0]),
					'email' => uniqid() . '@mailinator.com'
				);

				if(!Client::where('email', $client['email'])->count()) {
					Client::create($client);
					$clients++;
				}
			}

		}
	}

}


class AddresstypeSeeder extends Seeder {

	public function run() {
		DB::table('addresstypes')->delete();
		$types = array(
			array(
				'name'=>'shipping'
			),
			array(
				'name'=>'billing'
			)
		);
		foreach($types as $type) {
			Addresstype::create($type);
		}
	}

}


class AddressSeeder extends Seeder {

	public function run() {
		DB::table('addresses')->delete();

		foreach(Client::all() as $client) {

			foreach(Addresstype::all() as $addresstype) {

				$number = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,4));
				$street = Seed::data('streetnames')->shuffle()->get()[0];
				$suffix = Seed::data('streetsuffixes')->shuffle()->get()[0];
				$city = Seed::data('cities')->shuffle()->get()[0];
				$state = Seed::data('states')->shuffle()->get()[0]['abbreviation'];
				$zip = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,5));
				$phone = implode('',array_slice(Seed::data('numbers')->shuffle()->get(),0,10));

				$data = array(
					'address'=>$number.' '.ucfirst($street).' '.ucfirst($suffix),
					'city'=>ucfirst($city),
					'state'=>$state,
					'zip'=>$zip,
					'phone'=>$phone,
					'addresstype_id'=>$addresstype->id
				);

				$address = Address::create($data);

				$client->addresses()->save($address);
			}
		}
	}

}


class ScheduletimeSeeder extends Seeder {

	public function run() {
		DB::table('scheduletimes')->delete();

		$times = array(
			'before breakfast',
			'breakfast',
			'before lunch',
			'lunch',
			'before dinner',
			'dinner',
			'after dinner',
			'before bed'
		);

		foreach($times as $index=>$name) {
			Scheduletime::create(array('name'=>$name,'index'=>$index));
		}
	}
}


class SupplementSeeder extends Seeder {

	public function run() {
		DB::table('supplements')->delete();

		foreach(Subscriber::all() as $subscriber) {

			foreach (Seed::data('supplements')->get() as $supplement) {
				$supplement['price'] = implode('', array_slice(Seed::data('numbers')->shuffle()->get(), 0, 4)) / 100;
				$supplement['subscriber_id'] = $subscriber->id;

				if (!strlen($supplement['description'])) {
					$supplement['description'] = null;
					$supplement['short_description'] = null;
				} else {
					$supplement['short_description'] = substr($supplement['description'], 0, 150);
				}

				Supplement::create($supplement);
			}

		}
	}
}


class ProtocolSeeder extends Seeder {

	public function run() {
		foreach(Subscriber::all() as $subscriber) {

			$clients[] = Client::where('subscriber_id',$subscriber->id)->orderBy('last_name', 'asc')->first();

			foreach ($clients as $client) {

				$supplements = Supplement::where('subscriber_id',$subscriber->id)->get()->toArray();
				shuffle($supplements);

				$prescriptions = Seed::data('prescriptions')->get();

				for ($i = 0; $i < 20; $i++) {
					$protocol = Protocol::create(array(
						'client_id' => $client->id,
						'supplement_id' => $supplements[$i]['id']
					));

					foreach (Scheduletime::all() as $scheduletime) {
						if (rand(0, 1)) {
							shuffle($prescriptions);
							Schedule::create(array(
								'scheduletime_id' => $scheduletime->id,
								'prescription' => $prescriptions[0],
								'protocol_id' => $protocol->id
							));
						}
					}
				}

			}
		}
	}
}


class AutoshipfrequencySeeder extends Seeder {

	public function run() {
		$frequencies = array(
			array('name'=>'30 days'),
			array('name'=>'45 days'),
			array('name'=>'60 days')
		);

		foreach($frequencies as $frequency) {
			Autoshipfrequency::create($frequency);
		}
	}
}


class InputtypeSeeder extends Seeder {

	public function run() {
		$types = array(
			array(
				'name'=>'colorpicker'
			),
			array(
				'name'=>'file'
			),
			array(
				'name'=>'text'
			)
		);

		foreach($types as $type) {
			Inputtype::create($type);
		}
	}

}

class SettinggroupSeeder extends Seeder {

	public function run() {
		$groups = array(
			array(
				'name'=>'appearance',
				'scope_id'=>Scope::where('name','Subscriber')->pluck('id')
			),
			array(
				'name'=>'account',
				'scope_id'=>Scope::where('name','Subscriber')->pluck('id')
			)
		);

		foreach($groups as $group) {
			Settinggroup::create($group);
		}
	}

}


class SettingnameSeeder extends Seeder {

	public function run() {
		$appearance = array(
			array(
				'inputtype_id'=>Inputtype::where('name','colorpicker')->pluck('id'),
				'settinggroup_id'=>Settinggroup::where('name','appearance')->pluck('id'),
				'name'=>'theme color',
				'values'=>'#00B300,#CC280D,#078CD9,#B51FCD,#E46417,#00B2B3,#4F4D4E,#994800',
				'default'=>'#00B300'
			),
			array(
				'inputtype_id'=>Inputtype::where('name','file')->pluck('id'),
				'settinggroup_id'=>Settinggroup::where('name','appearance')->pluck('id'),
				'name'=>'logo',
				'description'=>'logo will be resized to fit within a 50 x 150 pixel rectangle. 2 mb max file size.'
			)
		);

		$account = array(
			array(
				'inputtype_id'=>Inputtype::where('name','text')->pluck('id'),
				'settinggroup_id'=>Settinggroup::where('name','account')->pluck('id'),
				'name'=>'primary contact email'
			)
		);

		$settings = array_merge(
			$appearance,
			$account
		);

		foreach($settings as $setting) {
			Settingname::create($setting);
		}
	}

}