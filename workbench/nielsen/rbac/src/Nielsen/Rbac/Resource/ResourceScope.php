<?php namespace Nielsen\Rbac\Resource;

use Nielsen\Rbac\Permission\Parts\Agent;

abstract class ResourceScope {

    /**
     * The name.
     *
     * @var string
     */
    public $name;

    /**
     * The owner.
     *
     * @var int
     */
    public $owner;

    /**
     * Create a new resource scope instance.
     *
     * @param string $name
     * @param int $owner
     * @return void
     */
    public function __construct($name,$owner) {
        $this->setName($name);

        $this->setOwner($owner);
    }

    /**
     * Set the name.
     *
     * @param string $name
     * @return void
     */
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

    /**
     * Set the owner.
     *
     * @param $owner
     * @return void
     */
    protected function setOwner($owner) {
        $this->owner = $owner;
    }

    /**
     * Return whether or not the scope contains a user.
     *
     * Calls the method of the child class corresponding to
     * the name property.
     *
     * @param Agent $user
     * @return mixed
     */
    public function hasUser(Agent $user) {
        $scopeMethod = $this->name;
        return $this->$scopeMethod($user,$this->owner);
    }

}