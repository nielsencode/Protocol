<?php

class AuthController extends BaseController {

	public function getLogin() {
		return View::make('auth.login');
	}

	public function postLogin() {
		$rules = array(
			'email'=>'required|email',
			'password'=>'required'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('login')->withErrors($validator)->withInput();
		}

		if(Auth::validate([
			'email'=>Input::get('email'),
			'password'=>Input::get('password')
		])) {
			$user = User::where('email',Input::get('email'))->first();
		}

		if(isset($user)) {
			if($user
				->subscribers()
				->where('subscriber_id',Subscriber::current()->id)
				->count()

				||

				$user->role->name=='protocol'
			) {
				$success = true;
			}
		}

		if(!empty($success)) {
			Auth::login($user);
			return Redirect::intended('home');
		}
		else {
			return Redirect::route('login')->withErrors(array('username or password is incorrect.'))->withInput();
		}
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::route('login');
	}

	public function getForgotPassword() {
		return View::make('auth.forgot_password');
	}

	public function postForgotPassword() {
		$rules = array(
			'email'=>'required|email'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('forgot password')->withErrors($validator)->withInput();
		}

		if(!$user = User::where('email',Input::get('email'))->first()) {
			$errors = array(
				'email'=>'A user with that address was not found.'
			);
			return Redirect::route('forgot password')->withErrors($errors)->withInput();
		}

		if($user->token) {
			$user->token->delete();
		}

		$token = Token::create(array(
			'expires_at'=>time()+(60*60*8)
		));

		$user->token_id = $token->id;

		$user->save();

		$link = route('reset password',array('token'=>$token->token));

		$user->sendEmail('Reset Password',array('text'=>'auth.emails.reset_password'),array(
			'first_name'=>$user->first_name,
			'link'=>$link
		));

		return Redirect::route('forgot password')->with('message','A link has been sent to reset your password.');
	}

	public function getSetPassword() {
		$token = token();

		return View::make('auth.setpassword')->with('token',$token);
	}

	public function postSetPassword() {
		$token = token();

		$rules = array(
			'password'=>'required',
			'retype_password'=>'required|same:password'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('set password',['token'=>$token->token])->withErrors($validator)->withInput();
		}

		$user = $token->user;

		$user->password = Input::get('password');

		$user->save();

		$token->delete();

		Auth::login($user);

		return Redirect::route('home');
	}

	public function getResetPassword() {
		$token = token();

		return View::make('auth.resetpassword')->with('token',$token);
	}

	public function postResetPassword() {
		$token = token();

		$rules = array(
			'password'=>'required',
			'retype_password'=>'required|same:password'
		);

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('reset password',['token'=>$token->token])->withErrors($validator)->withInput();
		}

		$user = $token->user;

		$user->password = Input::get('password');

		$user->save();

		$token->delete();

		Auth::login($user);

		return Redirect::route('home');
	}
}