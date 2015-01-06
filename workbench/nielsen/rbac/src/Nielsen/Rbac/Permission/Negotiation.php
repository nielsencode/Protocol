<?php namespace Nielsen\Rbac\Permission;

abstract class Negotiation {

    /**
     * The agent.
     *
     * @var \Nielsen\Rbac\Permission\Parts\Agent
     */
    public $agent;

    /**
     * The actions.
     *
     * @var array
     */
    public $actions;

    /**
     * The resource.
     *
     * @var \Nielsen\Rbac\Permission\Parts\Resource
     */
    public $resource;

    /**
     * The query.
     *
     * @var \Nielsen\Rbac\Permission\Query
     */
    protected $query;

    /**
     * Create a new negotiation instance.
     *
     * @param mixed $agent
     * @return void
     */
    public function __construct($agent) {
        $this->setAgent($agent);
    }

    /**
     * Set the agent.
     *
     * @param mixed $agent
     * @return void
     */
    protected function setAgent($agent) {
        $this->agent = new Parts\Agent($agent);
    }

    /**
     * Set the actions.
     *
     * @param string|array $actions
     * @return void
     */
    protected function setActions($actions) {
        $this->actions = Parts\Action::make($actions);
    }

    /**
     * Set the resource.
     *
     * @param string $type
     * @param int $id
     * @return void
     */
    protected function setResource($type,$id) {
        $this->resource = new Parts\Resource($type,$id);
    }

    /**
     * Set the query
     *
     * @return void
     */
    protected function setQuery() {
        $this->query = new Query($this);
    }

    /**
     * Get the query values for the negotiation.
     *
     * @abstract
     * @return array
     */
    abstract public function queryValues();

    /**
     * Setup the negotiation.
     *
     * @abstract
     * @return void
     */
    abstract protected function setup();

    /**
     * Set the resource, setup & execute the negotiation.
     *
     * @abstract
     * @param string $type
     * @param int|null $id
     * @return mixed
     */
    abstract public function over($type,$id=null);

}