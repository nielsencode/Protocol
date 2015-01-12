<?php namespace Nielsen\Rbac;

use Nielsen\Rbac\Permission\Grant;
use Nielsen\Rbac\Permission\Request;

class Rbac {

    /**
     * Entry point method for granting a permission.
     * Sets the agent for the permission.
     *
     * @param $agent
     * @return Grant
     */
    public static function let($agent)
    {
        return new Grant($agent);
    }

    /**
     * Entry point method for making a permission request.
     * Sets the agent for the request.
     *
     * @param $agent
     * @return Request
     */
    public static function check($agent)
    {
        return new Request($agent);
    }

    /**
     * Entry point method for requiring permission.
     * Calls the denied request handler on fail.
     * Sets the agent for the request.
     *
     * @param $agent
     * @return Request
     */
    public static function insist($agent)
    {
        return new Request($agent,true);
    }

    /**
     * Set the denied request handler on the request class.
     *
     * @param callable $closure
     * @return void
     */
    public static function deny(callable $closure) {
        Request::setDeny($closure);
    }

}