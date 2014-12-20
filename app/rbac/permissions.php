<?php

/*
|--------------------------------------------------------------------------
| Protocol
|--------------------------------------------------------------------------
|
*/

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Client');

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('User');

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Supplement');

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Protocol');

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Order');

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Setting');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|
*/

Rbac::let('admin')
	->have(array('read','add','edit','login'))
	->ofScope('Subscriber')
	->over('Client');

Rbac::let('admin')
	->have(array('read','edit'))
	->ofScope('Subscriber')
	->over('User');

Rbac::let('admin')
	->have('all')
	->ofScope('Subscriber')
	->over('Supplement');

Rbac::let('admin')
	->have(array('read','edit'))
	->ofScope('Subscriber')
	->over('Order');

/*
|--------------------------------------------------------------------------
| Subscriber
|--------------------------------------------------------------------------
|
*/

Rbac::let('subscriber')
	->have('all')
	->ofScope('Subscriber')
	->over('Client');

Rbac::let('subscriber')
	->have('all')
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

/*
|--------------------------------------------------------------------------
| Client
|--------------------------------------------------------------------------
|
*/

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