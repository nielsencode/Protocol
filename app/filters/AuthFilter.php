<?php

class AuthFilter {

	public function filter($route,$request,$value=null) {
		if (Auth::guest()) return Redirect::route('login');
	}
}