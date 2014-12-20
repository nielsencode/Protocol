<?php

Route::model('client','Client');

Route::model('order','Order');

Route::model('protocol','Protocol');

Route::model('supplement','Supplement');

Route::model('user','User');

Route::bind('cancelledOrder',function($value,$route) {
	return Order::where('id',$value)->withTrashed()->first();
});