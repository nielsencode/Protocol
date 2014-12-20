<?php namespace Nielsen\Rbac\Resource;

use Nielsen\Rbac\Permission\Parts\Agent;
use Nielsen\Rbac\Permission\Parts\Resource;

abstract class ResourceType {

    public $scope;

    public function __construct($scopeName,$scopeOwner) {
        $this->setScope($scopeName,$scopeOwner);
    }

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

    protected function hasScope($scopeName) {
        $scopeMethod = "scope{$scopeName}";
        return method_exists($this,$scopeMethod);
    }

    protected function newScope($scopeName,$scopeOwner) {
        $scopeClass = \Config::get('rbac::scope');
        return new $scopeClass($scopeName,$scopeOwner);
    }

    protected function namespaceName() {
        $reflection = new \ReflectionClass($this);
        return $reflection->getNamespaceName();
    }

    protected function shortName() {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    protected function type() {
        return $this->shortName();
    }

    protected function items() {
        $scopeMethod = "scope{$this->scope->name}";
        return $this->$scopeMethod($this->scope->owner);
    }

    protected function contains(Resource $resource) {
        return $resource->type==$this->type() && in_array($resource->id,$this->items());
    }

    public function hasUser(Agent $user) {
        return $this->scope->hasUser($user);
    }

    public function sharesWith(Agent $user,Resource $resource) {
        return $this->hasUser($user) && $this->contains($resource);
    }

}