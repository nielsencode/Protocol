<?php namespace Nielsen\Rbac\Permission;

class Grant extends Negotiation {

    /**
     * The scope argument.
     *
     * @var string
     */
    protected $scopeArgument;

    /**
     * The scope.
     *
     * @var \Nielsen\Rbac\Permission\Parts\Scope
     */
    public $scope;

    /**
     * Create a new grant instance.
     *
     * @param string $scope
     * @return void
     */
    protected function setScopeArgument($scope) {
        $this->scopeArgument = $scope;
    }

    /**
     * Set the scope.
     *
     * @return void
     */
    protected function setScope() {
        if(!$this->scopeArgument) {
            return;
        }

        $this->scope = new Parts\Scope($this->scopeArgument,$this->resource->type);
    }

    /**
     * Chainable method to set the actions.
     *
     * @param string|array $actions
     * @return $this
     */
    public function have($actions) {
        $this->setActions($actions);

        return $this;
    }

    /**
     * Chainable method to set the scope.
     *
     * @param string $scope
     * @return $this
     */
    public function ofScope($scope) {
        if(!empty($this->scopeArgument)) {
            throw new \LogicException('"ofScope" may only be called once.');
        }

        $this->setScopeArgument($scope);

        return $this;
    }

    /**
     * Set the resource, setup & execute the grant.
     *
     * @param string $type
     * @param int|null $id
     * @return mixed
     */
    public function over($type,$id=null) {
        if(!$this->scopeArgument && !$id) {
            throw new \InvalidArgumentException('Must use scope for resource of type.');
        }

        if($this->scopeArgument && $id) {
            throw new \InvalidArgumentException('Cannot use scope for single resource.');
        }

        $this->setResource($type,$id);

        $this->setup();

        return $this->make();
    }

    /**
     * Setup the grant.
     *
     * @return void
     */
    protected function setup() {
        $this->setScope();

        $this->setQuery();
    }

    /**
     * Make the grant.
     *
     * @return mixed
     */
    protected function make() {
        return $this->query->grant();
    }

    /**
     * Get the query values for the grant.
     *
     * @return array
     */
    public function queryValues() {
        $values = [
            'agent_type'=>$this->agent->type,
            'agent_id'=>$this->agent->id,
            'role_id'=>$this->agent->roleId(),
            'resource_type'=>$this->resource->type,
            'resource_id'=>$this->resource->id,
            'scope_id'=>$this->scope ? $this->scope->id : null,
            'actions'=>'%'
        ];

        foreach($this->actions as $action) {
            $values['actions'] .= $action->id.'%';
        }

        return $values;
    }

}