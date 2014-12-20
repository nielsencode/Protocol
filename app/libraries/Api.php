<?php

class Api {

	public static function response($data) {
		if($data) {echo $data->toJson();}
		exit();
	}
	
	public static function where() {
		foreach(\Input::all() as $k=>$v) {
			$where[] = $k."="."'".$v."'";
		}
		return implode(' and ',$where);
	}

}