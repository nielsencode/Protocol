<?php namespace Nielsen\Rbac\Resource;

use Nielsen\Rbac\Permission\Parts\Agent;

abstract class ResourceScope {

    public $name;

    public $owner;

    public function __construct($name,$owner) {
        $this->setName($name);
        $this->setOwner($owner);
    }

    protected function setName($name) {
        if(method_exists($this,$name)) {
            $this->name = $name;
            return;
        }

        $args = array(
            $name,
            get_called_class()
        );

        throw new \InvalidArgumentException(vsprintf('Scope %s not defined in %s',$args));
    }

    protected function setOwner($owner) {
        $this->owner = $owner;
    }

    public function hasUser(Agent $user) {
        $scopeMethod = $this->name;
        return $this->$scopeMethod($user,$this->owner);
    }

}