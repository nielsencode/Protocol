<?php

namespace Clients;

class AddComposer {

	public function compose($view) {
		$statesData = \Seed::data('states')->get();
		$states[] = '---';
		foreach($statesData as $state) {
			$states[$state['abbreviation']] = $state['name'];
		}

		$data = array(
			'states'=>$states
		);

		$view->with($data);
	}
}