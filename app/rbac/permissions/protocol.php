<?php

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

Rbac::let('protocol')
	->have('all')
	->ofScope('Protocol')
	->over('Autoship');