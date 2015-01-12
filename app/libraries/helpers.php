<?php

use Carbon\Carbon as Carbon;

function export($var,$die=true) {
	echo '<pre>';
	var_export($var);
	echo '</pre>';

	if($die) {
		die();
	}
}

/**
 * Flatten a multi-dimensional array by concatenating each tree into a single key using delimeter.
 *
 * @param array $array The array to flatten.
 * @param array $flat Array to store the results.
 * @param string $key Key prefix. Defaults to ''.
 * @param string $delim Delimeter to join key parts.
 */
function arrayFlatten($array,&$flat,$delim="=>",$key='') {
	foreach($array as $k=>$v) {
		if(is_array($v)) {
			arrayFlatten($v,$flat,$delim,strlen($key) ? "$key$delim$k" : $k);
		}
		else {
			$flat[strlen($key) ? "$key$delim$k" : $k] = $v;
		}
	}
}// end function array_flatten


/**
 * Expand a flattened multi-dimensional array.
 *
 * @param array $array The array to be expanded.
 * @param array $expanded Array to store the results.
 * @param string $delim Delimeter to split flattened keys by.
 */
function arrayExpand($array,&$expanded,$delim="=>"){
	foreach($array as $k=>$v) {
		$a = &$expanded;
		$keys = explode($delim,$k);
		while(count($keys)>0) {
			$branch = array_shift($keys);
			if(!is_array($a)) {
				$a = array();
			}
			$a = &$a[$branch];
		}
		$a = $v;
	}
}


function csvToArray($csv) {
	$lines = explode("\n",$csv);
	$keys = str_getcsv(array_shift($lines));
	$data = array();
	foreach($lines as $line) {
		$datum = @array_combine($keys,str_getcsv($line));
		if($datum) {
			$data[] = $datum;
		}
	}
	return $data;
}


/**
 * Rebuilds the current query string with sorting parameters.
 *
 * Sortby() removes the 'page' pagination parameter.
 *
 * @param string $sortby Column to sort by
 * @param string $order ASC or DESC
 * @return string
 */
function sortby($sortby,$order) {
	return '?'.http_build_query(array_merge(Input::except('page'),array(
		'sortby'=>$sortby,
		'order'=>$order
	)));
}


function pageLinks($paginator) {
	return $paginator->appends(array_diff_key(Input::all(),array_flip(array('page'))))->links();
}


function timeForHumans(Carbon $date) {
	$now = new Carbon;

	switch(true) {
		case $now->format('ymd')==$date->format('ymd'):
			$date = "Today";
			break;
		case $now->modify('yesterday')->format('ymd')==$date->format('ymd'):
			$date = "Yesterday";
			break;
		default:
			$date = $date->format('F d, Y');
			break;
	}

	return $date;
}

function token() {
	if(!$token = Input::get('token')) {
		App::abort(404);
	}

	if(!$token = Token::where('token',$token)->first()) {
		App::abort(404);
	}

	if($token->expired()) {
		App::abort(404);
	}

	return $token;
}

function location($address) {
	$api = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

	$uri = sprintf($api,rawurlencode($address));

	$result = json_decode(file_get_contents($uri));

	if(!$result->results) {
		return false;
	}

	return $result->results[0];
}