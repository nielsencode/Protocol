<?php

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Client');

Rbac::let('subscriber')
	->have(array('read','add','edit','delete'))
	->ofScope('Subscriber')
	->over('User');

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Supplement');

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Protocol');

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Order');

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Setting');

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Autoship');