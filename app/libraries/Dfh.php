<?php

class Dfh {

	public $baseUrl = 'http://catalog.designsforhealth.com';

	public function html() {
		return file_get_contents($this->url);
	}
}

class Catalog extends Dfh {

	public $url = '/Online-Catalog/A-to-Z';

	public function __construct() {
		$this->url = $this->baseUrl.$this->url;
	}

	public function categories() {
		$pattern = '/<td class="catcelltd">\s*<h3>\s*<a href="([^"]+)">([^<]+)<\/a>\s*<\/h3>\s*<\/td>/';
		preg_match_all($pattern,$this->html(),$matches,PREG_PATTERN_ORDER);

		foreach($matches[1] as $k=>$v) {
			$categories[] = new Category($matches[2][$k],$this->baseUrl.$v);
		}

		return $categories;
	}
}

Class Category extends Dfh {

	public function __construct($name,$url) {
		$this->name = $name;
		$this->url = $url;
	}

	public function products() {
		$pattern = '/<a href="([^"]+)" class="blue_button">more details[^<]*<\/a>/';

		preg_match_all($pattern,$this->html(),$matches,PREG_PATTERN_ORDER);

		foreach($matches[1] as $v) {
			$products[] = new Product($this->baseUrl.$v);
		}

		return $products;
	}
}

class Product extends Dfh {

	public function __construct($url) {
		$this->url = $url;
	}

	private function getName($html) {
		$pattern = '/<h1>([^<]+)<\/h1>/';
		preg_match($pattern,$html,$matches);
		return filter_var($matches[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	private function getDescription($html) {
		$pattern = '/<div id="item_description">(.+)<\/div>/';
		preg_match($pattern,$html,$matches);
		return !isset($matches[1]) ? '' : filter_var($matches[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	private function shortDescription($description) {
		return substr($description,0,200);
	}

	public function info() {
		$html = $this->html();

		$name = $this->getName($html);
		$long_desc = $this->getDescription($html);
		$short_desc = $this->shortDescription($long_desc);

		return array(
			'name'=>$name,
			'long_desc'=>$long_desc,
			'short_desc'=>$short_desc
		);
	}
}