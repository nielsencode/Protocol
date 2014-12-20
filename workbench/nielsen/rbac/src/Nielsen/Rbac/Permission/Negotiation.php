<?php namespace Nielsen\Rbac\Permission;

abstract class Negotiation {

    public $agent;

    public $actions;

    public $resource;

    protected $query;

    public function __construct($agent) {
        $this->setAgent($agent);
    }

    protected function setAgent($agent) {
        $this->agent = new Parts\Agent($agent);
    }

    protected function setActions($actions) {
        $this->actions = Parts\Action::make($actions);
    }

    protected function setResource($type,$id) {
        $this->resource = new Parts\Resource($type,$id);
    }

    protected function setQuery() {
        $this->query = new Query($this);
    }

    abstract public function queryValues();

    abstract public function over($type,$id=null);

}