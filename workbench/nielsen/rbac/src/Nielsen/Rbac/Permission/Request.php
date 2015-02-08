<?php namespace Nielsen\Rbac\Permission;

class Request extends Negotiation {

    /**
     * Whether or not to execute the denied request handler on failure.
     *
     * @var bool
     */
    protected $require;

    /**
     * The scopes.
     *
     * @var array
     */
    public $scopes = [];

    /**
     * The scope arguments.
     *
     * @var array
     */
    protected $scopeArguments = [];

    /**
     * The denied request handler.
     *
     * @var callable
     */
    protected static $deny;

    /**
     * Create a new request instance.
     *
     * @param mixed $agent
     * @param bool $require
     * @return void
     */
    public function __construct($agent,$require=false) {
        $this->setRequire($require);
        parent::__construct($agent);
    }

    /**
     * Set the denied request handler.
     *
     * @param callable $closure
     * @return void
     */
    public static function setDeny(callable $closure) {
        self::$deny = $closure;
    }

    /**
     * Set the agent.
     *
     * @param mixed $agent
     * @return void
     */
    protected function setAgent($agent) {
        parent::setAgent($agent);

        if($this->agent->type!=='User') {
            throw new \InvalidArgumentException("Agent must be a user.");
        }
    }

    /**
     * Set whether or not permission is required.
     *
     * @param bool $require
     * @return void
     */
    protected function setRequire($require) {
        $this->require = $require;
    }

    /**
     * Add a scope argument.
     *
     * @param string $scope
     * @param int $id
     * @return void
     */
    protected function addScopeArgument($scope,$id) {
        $this->scopeArguments[$scope] = [
            'name'=>$scope,
            'id'=>$id
        ];
    }

    /**
     * Add a scope.
     *
     * @param string $scope
     * @param string $resourceType
     * @param int $id
     * @return void
     */
    protected function addScope($scope,$resourceType,$id) {
        $this->scopes[] = new Parts\Scope($scope,$resourceType,$id);
    }

    /**
     * Set the scopes.
     *
     * @return void
     */
    protected function setScopes() {
        foreach($this->scopeArguments as $scope) {
            $this->addScope($scope['name'],$this->resource->type,$scope['id']);
        }
    }

    /**
     * Chainable method to set the actions.
     *
     * @param string|array $actions
     * @return $this
     */
    public function has($actions) {
        $this->setActions($actions);

        return $this;
    }

    /**
     * Chainable method to set the scope.
     *
     * @param string $scope
     * @param int|null $id
     * @return $this
     */
    public function ofScope($scope,$id=null) {
        if(!empty($this->scopeArguments)) {
            throw new \LogicException('"ofScope" may only be called once. Use "orScope" to add more scopes.');
        }

        $this->addScopeArgument($scope,$id);

        return $this;
    }

    /**
     * Chainable method to set an additional scope beyond the first.
     *
     * @param string $scope
     * @param int|null $id
     * @return $this
     */
    public function orScope($scope,$id=null) {
        if(empty($this->scopeArguments)) {
            throw new \LogicException('"orScope" may only be called after "ofScope"');
        }

        $this->addScopeArgument($scope,$id);
        return $this;
    }

    /**
     * Set the resource, setup & execute the request.
     *
     * @param string $type
     * @param int|null $id
     * @return mixed
     */
    public function over($type,$id=null) {
        if(!$this->scopeArguments && !$id) {
            throw new \InvalidArgumentException('Must provide scope for resource of type.');
        }

        $this->setResource($type,$id);

        $this->setup();

        return $this->make();
    }

    /**
     * Setup the request.
     *
     * @return void
     */
    protected function setup() {
        $this->setScopes();

        $this->setQuery();
    }

    /**
     * Return whether or not the request is for a single resource.
     *
     * @return bool
     */
    protected function isSingleResource() {
        return empty($this->scopes);
    }

    /**
     * Return whether or not the request has scope.
     *
     * @return bool
     */
    protected function hasScope() {
        return !empty($this->scopes);
    }

    /**
     * Get the request as a human-readable string.
     *
     * @return string
     */
    public function toString() {
        $output = '%s %s %s %s of scope %s over %s%s.';

        $args = [
            $this->agent->type,
            $this->agent->id,
            $this->require ? 'requires' : 'requestes',
            implode(',',array_map(function($v) {return $v->name;},$this->actions)),
            implode(' or ',array_map(function($v) {return $v->name;},$this->scopes)),
            $this->resource->type,
            $this->resource->id ? " {$this->resource->id}" : ''
        ];

        return vsprintf($output,$args);
    }

    /**
     * Get the query values for the request.
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
            'actions'=>'%'
        ];

        foreach($this->scopes as $i=>$scope) {
            $values["scope_id_$i"] = $scope->id;
        }

        foreach($this->actions as $action) {
            $values['actions'] .= $action->id.'%';
        }

        return $values;
    }

    /**
     * Make the request.
     *
     * @return bool
     */
    protected function make() {
        return $this->require ? $this->requirePermission() : $this->requestPermission();
    }

    /**
     * Return whether or not a scope shares the request's resource
     * with the request's agent.
     *
     * @param Parts\Scope $scope
     * @return bool
     */
    protected function scopeSharesWith(Parts\Scope $scope) {
        $scope = $this->resource->make($scope->name,$scope->owner);

        if($scope->sharesWith($this->agent,$this->resource)) {
            return true;
        }

        return false;
    }

    /**
     * Return whether or not a scope contains the request's user.
     *
     * @param Parts\Scope $scope
     * @return bool
     */
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

    /**
     * Find permissions of scope matching the request.
     *
     * @return bool
     */
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

    /**
     * Call the denied request handler.
     *
     * @return mixed
     */
    protected function deny() {
        return self::$deny->__invoke($this);
    }

    /**
     * Find permissions matching the request.
     *
     * @return bool
     */
    protected function requestPermission() {
        if(!$this->hasScope()) {
            return $this->query->singleResource();
        }

        if($this->hasScope()) {
            return $this->permissionOfScope();
        }
    }

    /**
     * Find permissions matching the request, and execute the denied request
     * handler on failure.
     *
     * @return bool|mixed
     */
    protected function requirePermission() {
        $permission = $this->requestPermission();

        if($permission) {
            return $permission;
        }

        return $this->deny();
    }

}