<?php

Rbac::let('client')
	->have(array('read','edit'))
	->ofScope('Client')
	->over('Client');

Rbac::let('client')
	->have('read')
	->ofScope('Subscriber')
	->over('Supplement');

Rbac::let('client')
	->have(array('read','add','delete'))
	->ofScope('Client')
	->over('Order');

Rbac::let('client')
	->have(array('read','edit'))
	->ofScope('Client')
	->over('User');

Rbac::let('client')
	->have('read')
	->ofScope('Client')
	->over('Protocol');

Rbac::let('client')
	->have('read')
	->ofScope('Subscriber')
	->over('Setting');