<?php

namespace Layouts\Master;

class IndextableComposer {

	public function compose($view) {
		if(!\Input::get('order')) {
			$sortorder = 'asc';
		}
		else {
			$sortorder = \Input::get('order')=='asc' ? 'desc' : 'asc';
		}

		$view->with('sortorder',$sortorder);
	}
}