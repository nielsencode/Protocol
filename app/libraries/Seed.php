<?php

class Seed {

	public function __construct() {
	}

	public static function path() {
		return public_path().'/assets/data/seeds/';
	}

	public static function seedFiles() {
		$allFiles = scandir(self::path());
		foreach($allFiles as $file) {
			if(preg_match('/(.+)\.json$/',$file,$matches)==1) {
				$seedFiles[$matches[1]] = self::path().$file;
			}
		}
		return $seedFiles;
	}

	public static function data($name) {
		$seed = new self();
		$seed->data = json_decode(file_get_contents(self::seedFiles()[$name]),true);
		return $seed;
	}

	public function shuffle() {
		shuffle($this->data);
		return $this;
	}

	public function get() {
		return $this->data;
	}
}