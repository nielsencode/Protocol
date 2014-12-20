<?php namespace Nielsen\Rbac\Permission;

class Grant extends Negotiation {

    protected $scopeArgument;

    public $scope;

    protected function setScopeArgument($scope) {
        $this->scopeArgument = $scope;
    }

    protected function setScope() {
        if(!$this->scopeArgument) {
            return false;
        }

        $type = $this->resource->type;

        $this->scope = new Parts\Scope($this->scopeArgument,$type);
    }

    public function have($actions) {
        $this->setActions($actions);
        return $this;
    }

    public function ofScope($scope) {
        if(!empty($this->scopeArgument)) {
            throw new \LogicException('"ofScope" may only be called once.');
        }

        $this->setScopeArgument($scope);
        return $this;
    }

    public function over($type,$id=null) {
        if(!$this->scopeArgument && !$id) {
            throw new \InvalidArgumentException('Must use scope for resource of type.');
        }

        if($this->scopeArgument && $id) {
            throw new \InvalidArgumentException('Cannot use scope for single resource.');
        }

        $this->setResource($type,$id);
        $this->setScope();
        $this->setQuery();

        return $this->make();
    }

    protected function make() {
        return $this->query->grant();
    }

    public function queryValues() {
        $values = array(
            'agent_type'=>$this->agent->type,
            'agent_id'=>$this->agent->id,
            'role_id'=>$this->agent->roleId(),
            'resource_type'=>$this->resource->type,
            'resource_id'=>$this->resource->id,
            'scope_id'=>$this->scope ? $this->scope->id : null,
            'actions'=>'%'
        );

        foreach($this->actions as $action) {
            $values['actions'] .= $action->id.'%';
        }

        return $values;
    }

}