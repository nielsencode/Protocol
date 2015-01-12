<?php

class Breadcrumbs {

	public static function delimeterHtml() {
		return '<a class="breadcrumb-delimeter"></a>';
	}

	public static function make($data) {
		foreach($data as $title=>$link) {
			if(!empty($link)) {
				$breadcrumbs[] = "<a class=\"breadcrumb\" href=\"{$link}\">".ucwords($title)."</a>";
			}
			else {
				$breadcrumbs[] = "<a class=\"disabled-breadcrumb\">".ucwords($title)."</a>";
			}
		}
		return implode(self::delimeterHtml(),$breadcrumbs);
	}
}