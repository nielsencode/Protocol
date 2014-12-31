<?php

class HelpController extends BaseController {

	public function getIndex() {
		return View::make('help');
	}

	public function postIndex() {
		$rules = [
			'name'=>'required',
			'email'=>'required|email',
			'subject'=>'required',
			'message'=>'required'
		];

		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::route('help')->withErrors($validator)->withInput();
		}

		$email = [
			'to'=>'task@producteev.com',
			'fromEmail'=>'bluemoonballoon@gmail.com',
			'subject'=>sprintf("%s #Support +Eric Nielsen",
				Input::get('subject')
			)
		];

		$data = [
			'body'=>sprintf("%s <%s>:\n\n%s",
				Input::get('name'),
				Input::get('email'),
				Input::get('message')
			)
		];

		Mail::queue(['text'=>'emails.support.support'],$data,function($message) use ($email) {
			$message
				->to($email['to'])
				->from($email['fromEmail'])
				->subject($email['subject']);
		});

		return Redirect::route('help')->with('success',true);
	}

}