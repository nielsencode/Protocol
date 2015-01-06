<?php namespace Nielsen\Rbac\Resource;

use Nielsen\Rbac\Permission\Parts\Agent;
use Nielsen\Rbac\Permission\Parts\Resource;

abstract class ResourceType {

    /**
     * The scope.
     *
     * @var \Nielsen\Rbac\Resource\ResourceScope
     */
    public $scope;

    /**
     * Create a new resource type instance.
     *
     * @param string $scopeName
     * @param int $scopeOwner
     * @return void
     */
    public function __construct($scopeName,$scopeOwner) {
        $this->setScope($scopeName,$scopeOwner);
    }

    /**
     * Set the scope.
     *
     * @param string $scopeName
     * @param int $scopeOwner
     * @return void
     */
    protected function setScope($scopeName,$scopeOwner) {
        if($this->hasScope($scopeName)) {
            $this->scope = $this->newScope($scopeName,$scopeOwner);
            return;
        }

        $args = array(
            $scopeName,
            get_called_class()
        );

        throw new \InvalidArgumentException(vsprintf('Scope "%s" not defined in %s.',$args));
    }

    /**
     * Check if the resource type has a method corresponding to the scope name.
     *
     * @param string $scopeName
     * @return bool
     */
    protected function hasScope($scopeName) {
        $scopeMethod = "scope{$scopeName}";
        return method_exists($this,$scopeMethod);
    }

    /**
     * Get a new resource scope instance.
     *
     * @param string $scopeName
     * @param int $scopeOwner
     * @return \Nielsen\Rbac\Resource\ResourceScope
     */
    protected function newScope($scopeName,$scopeOwner) {
        $scopeClass = \Config::get('rbac::scope');
        return new $scopeClass($scopeName,$scopeOwner);
    }

    /**
     * Get the namespace of the resource type.
     *
     * @return string
     */
    protected function namespaceName() {
        $reflection = new \ReflectionClass($this);
        return $reflection->getNamespaceName();
    }

    /**
     * Get the class name of the resource type.
     *
     * @return string
     */
    protected function shortName() {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    /**
     * Get the type.
     *
     * @return string
     */
    protected function type() {
        return $this->shortName();
    }

    /**
     * Get the items belonging to the resource type and its scope.
     *
     * @return array
     */
    protected function items() {
        $scopeMethod = "scope{$this->scope->name}";
        return $this->$scopeMethod($this->scope->owner);
    }

    /**
     * Check if a single resource belongs to this resource type in its scope.
     *
     * @param Resource $resource
     * @return bool
     */
    protected function contains(Resource $resource) {
        return $resource->type==$this->type() && in_array($resource->id,$this->items());
    }

    /**
     * Check if the resource type's scope contains a user.
     *
     * @param Agent $user
     * @return bool
     */
    public function hasUser(Agent $user) {
        return $this->scope->hasUser($user);
    }

    /**
     * Check if the resource type shares a single resource with a user
     * in its scope.
     *
     * @param Agent $user
     * @param Resource $resource
     * @return bool
     */
    public function sharesWith(Agent $user,Resource $resource) {
        return $this->hasUser($user) && $this->contains($resource);
    }

}