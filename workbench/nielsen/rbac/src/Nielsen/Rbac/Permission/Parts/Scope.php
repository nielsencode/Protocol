<?php namespace Nielsen\Rbac\Permission\Parts;

class Scope {

    public $id;

    public $name;

    public $owner;

    public function __construct($scopeName,$type,$owner=null) {
        $this->setId($scopeName);
        $this->setName($scopeName);
        $this->setOwner($type,$owner);
    }

    protected function setId($scopeName) {
        if($id = \Scope::where('name',$scopeName)->pluck('id')) {
            $this->id = $id;
            return;
        }

        throw new \InvalidArgumentException(sprintf('Scope name "%s" could not be found.',$scopeName));
    }

    protected function setName($scopeName) {
        if(\Scope::where('name',$scopeName)->count()) {
            $this->name = $scopeName;
            return;
        }

        throw new \InvalidArgumentException(sprintf('Scope name "%s" could not be found.',$scopeName));
    }

    protected function setOwner($type,$owner) {
        if(is_null($owner)) {
            $this->owner = $owner;
            return false;
        }

        if("\\".$type::where('id',$owner)->count()) {
            $this->owner = $owner;
            return;
        }

        throw new \InvalidArgumentException(sprintf('%s with id %s could not be found.',$type,$owner));
    }

}