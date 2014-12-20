<?php namespace Nielsen\Rbac;

use Nielsen\Rbac\Permission\Request;

Rbac::deny(function(Request $request) {
    export($request->toString());
});