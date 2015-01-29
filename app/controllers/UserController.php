<?php

class UserController extends BaseController {

	public function getIndex() {
		Auth::user()
			->requires('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		$users = Subscriber::current()
			->users()
			->join('roles','roles.id','=','users.role_id');

		/*$users = User::where('subscriber_id',Subscriber::current()->id)
			->join('roles','roles.id','=','users.role_id');*/

		switch(Auth::user()->role->name) {
			case 'protocol':
				$roles = array('subscriber','admin','client');
				break;
			case 'subscriber':
				$roles = array('admin','client');
				break;
			case 'admin':
				$roles = array('client');
				break;
		}

		if(Input::get('q')) {
			$users = $users->where('fulltext','LIKE','%'.Input::get('q').'%');
		}

		if(Input::get('sortby')) {
			$users = $users->orderBy(Input::get('sortby'),Input::get('order'));
		}
		else {
			$users = $users->orderBy('roles.name','asc')->orderBy('last_name','asc');
		}

		$users->select(array('users.*','roles.id AS role_id'));

		$data['users'] = $users->paginate(15);

		return View::make('users.index',$data);
	}

	public function getUser($user) {
		Auth::user()
			->requires('read')
			->ofScope('User',$user->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id);

		return View::make('users.user',array(
			'user'=>$user
		));
	}

	public function getAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		return View::make('users.add');
	}

	public function postAdd() {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		$rules = array(
			'email'=>'required',
			'first_name'=>'required',
			'last_name'=>'required',
			'role'=>'required'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('add user')->withErrors($validator)->withInput();
		}

		$values = array(
			'first_name'=>Input::get('first_name'),
			'last_name'=>Input::get('last_name'),
			'email'=>Input::get('email'),
			'role_id'=>Input::get('role')
		);

		if($user = User::where('email',Input::get('email'))->withTrashed()->first()) {
			$user->restore();
			$user->fill($values);
			$user->save();
			$user->subscribers()->attach(Subscriber::current()->id);
		}
		else {
			$user = User::create($values);
			$user->subscribers()->attach(Subscriber::current()->id);
		}

		$this->newAccountInvitation($user);

		return Redirect::route('user',$user->id);
	}

	public function getEdit($user) {
		Auth::user()
			->requires('edit')
			->ofScope('User',$user->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id);

		return View::make('users.edit',array(
			'user'=>$user
		));
	}

	public function postEdit($user) {
		Auth::user()
			->requires('edit')
			->ofScope('User',$user->id)
			->orScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id);

		if(!Input::has('token')) {
			$rules = array(
				'first_name'=>'required',
				'last_name'=>'required',
				'email'=>"required|email|unique:users,email,{$user->id}",
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
				return Redirect::route('reset password',array('token'=>Input::get('token')))->withErrors($validator)->withInput();
			}

			return Redirect::route('edit user',array($user->id))->withErrors($validator)->withInput();
		}

		if($token = $user->token) {
			$token->delete();
		}

		$input = Input::all();
		$input['token_id'] = null;

		$user->update(Input::all());

		//Auth::login($user);

		return Redirect::route('user',array($user->id));
	}

	public function getLoginAs($user) {
		Auth::user()
			->has('login')
			->ofScope('Protocol')
			->over('User',$user->id);

		Auth::login($user);

		return Redirect::route('home');
	}

	public function newAccountInvitation($user) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		if($token = $user->token) {
			$token->delete();
		}

		$token = Token::create(array(
			'expires_at'=>-1
		));

		$user->token_id = $token->id;

		$user->save();

		$user->sendEmail('New Account',array('text'=>'auth.emails.new_account'),array(
			'subscriber'=>Subscriber::current()->name,
			'link'=>route('set password',array('token'=>$token->token))
		));
	}

	public function getNewAccountInvitation($user) {
		Auth::user()
			->requires('add')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User');

		$this->newAccountInvitation($user);

		return Redirect::route('user',$user->id);
	}

	public function postDelete($user) {
		Auth::user()
			->requires('delete')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User',$user->id);

		$user->delete();

		return Redirect::route('users');
	}
}