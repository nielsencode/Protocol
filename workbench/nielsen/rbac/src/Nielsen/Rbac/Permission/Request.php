<?php namespace Nielsen\Rbac\Permission;

class Request extends Negotiation {

    protected $require;

    public $scopes = array();

    protected $scopeArguments = array();

    protected static $deny;

    public function __construct($agent,$require=false) {
        $this->setRequire($require);
        parent::__construct($agent);
    }

    public static function setDeny(callable $closure) {
        self::$deny = $closure;
    }

    protected function setAgent($agent) {
        parent::setAgent($agent);

        if($this->agent->type!=='User') {
            throw new \InvalidArgumentException("Agent must be a user.");
        }
    }

    protected function setRequire($require) {
        $this->require = $require;
    }

    protected function addScopeArgument($scope,$id) {
        $this->scopeArguments[$scope] = array(
            'name'=>$scope,
            'id'=>$id
        );
    }

    protected function addScope($scope,$type,$id) {
        $this->scopes[] = new Parts\Scope($scope,$type,$id);
    }

    protected function setScopes() {
        $type = $this->resource->type;

        foreach($this->scopeArguments as $scope) {
            $this->addScope($scope['name'],$type,$scope['id']);
        }
    }

    public function has($actions) {
        $this->setActions($actions);
        return $this;
    }

    public function ofScope($scope,$id=null) {
        if(!empty($this->scopeArguments)) {
            throw new \LogicException('"ofScope" may only be called once. Use "orScope" to add more scopes.');
        }

        $this->addScopeArgument($scope,$id);
        return $this;
    }

    public function orScope($scope,$id=null) {
        if(empty($this->scopeArguments)) {
            throw new \LogicException('"orScope" may only be called after "ofScope"');
        }

        $this->addScopeArgument($scope,$id);
        return $this;
    }

    public function over($type,$id=null) {
        if(!$this->scopeArguments && !$id) {
            throw new \InvalidArgumentException('Must provide scope for resource of type.');
        }

        $this->setResource($type,$id);
        $this->setScopes();
        $this->setQuery();

        return $this->make();
    }

    protected function isSingleResource() {
        return empty($this->scopes);
    }

    protected function hasScope() {
        return !empty($this->scopes);
    }

    public function toString() {
        $output = '%s %s %s %s of scope %s over %s%s.';

        $args = array(
            $this->agent->type,
            $this->agent->id,
            $this->require ? 'requires' : 'requestes',
            implode(',',array_map(function($v) {return $v->name;},$this->actions)),
            implode(' or ',array_map(function($v) {return $v->name;},$this->scopes)),
            $this->resource->type,
            $this->resource->id ? " {$this->resource->id}" : ''
        );

        return vsprintf($output,$args);
    }

    public function queryValues() {
        $values = array(
            'agent_type'=>$this->agent->type,
            'agent_id'=>$this->agent->id,
            'role_id'=>$this->agent->roleId(),
            'resource_type'=>$this->resource->type,
            'resource_id'=>$this->resource->id,
            'actions'=>'%'
        );

        foreach($this->scopes as $i=>$scope) {
            $values["scope_id_$i"] = $scope->id;
        }

        foreach($this->actions as $action) {
            $values['actions'] .= $action->id.'%';
        }

        return $values;
    }

    protected function make() {
        return $this->require ? $this->requirePermission() : $this->requestPermission();
    }

    protected function scopeSharesWith(Parts\Scope $scope) {
        $scope = $this->resource->make($scope->name,$scope->owner);

        if($scope->sharesWith($this->agent,$this->resource)) {
            return true;
        }

        return false;
    }

    protected function scopeHasUser(Parts\Scope $scope) {
        if(!$scope->owner) {
            return true;
        }

        $scope = $this->resource->make($scope->name,$scope->owner);

        if($scope->hasUser($this->agent)) {
            return true;
        }

        return false;
    }

    protected function permissionOfScope() {
        if($this->isSingleResource()) {
            if($this->query->singleResource()) {
                return true;
            }
        }

        if(!$permission = $this->query->resourceType()) {
            return false;
        }

        $scope = array_values(array_filter($this->scopes,function($v) use ($permission) {
            return $v->id==$permission->scope_id;
        }))[0];

        if($this->resource->id) {
            return $this->scopeSharesWith($scope);
        }

        if(!$this->resource->id) {
            return $this->scopeHasUser($scope);
        }
    }

    protected function deny() {
        return self::$deny->__invoke($this);
    }

    protected function requestPermission() {
        if(!$this->hasScope()) {
            return $this->query->singleResource();
        }

        if($this->hasScope()) {
            return $this->permissionOfScope();
        }
    }

    protected function requirePermission() {
        $permission = $this->requestPermission();

        if($permission) {
            return $permission;
        }

        return $this->deny();
    }

}