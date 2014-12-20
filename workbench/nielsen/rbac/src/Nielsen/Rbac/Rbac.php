<?php namespace Nielsen\Rbac;

use Nielsen\Rbac\Permission\Grant;
use Nielsen\Rbac\Permission\Request;

class Rbac {

    public static function let($agent)
    {
        return new Grant($agent);
    }

    public static function check($agent)
    {
        return new Request($agent);
    }

    public static function insist($agent)
    {
        return new Request($agent,true);
    }

    public static function deny(callable $closure) {
        Request::setDeny($closure);
    }

}