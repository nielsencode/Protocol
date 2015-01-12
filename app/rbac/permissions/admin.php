<?php

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

Rbac::let('admin')
	->have('all')
	->ofScope('Subscriber')
	->over('Protocol');