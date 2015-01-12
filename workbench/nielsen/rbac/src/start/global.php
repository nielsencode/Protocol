<?php namespace Nielsen\Rbac;

use Nielsen\Rbac\Permission\Request;

/*
|--------------------------------------------------------------------------
| Denied Permission Request Handler
|--------------------------------------------------------------------------
|
| This handler fires when a required permission cannot be found.
|
*/

Rbac::deny(function(Request $request) {

    die("<pre>{$request->toString()}</pre>");

});