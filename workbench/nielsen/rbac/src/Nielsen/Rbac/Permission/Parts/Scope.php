<?php namespace Nielsen\Rbac\Permission\Parts;

class Scope {

    /**
     * The scope id.
     *
     * @var int
     */
    public $id;

    /**
     * The scope name.
     *
     * @var string
     */
    public $name;

    /**
     * The scope owner.
     *
     * @var int
     */
    public $owner;

    /**
     * Create a new scope instance.
     *
     * @param string $scopeName
     * @param string $resourceType
     * @param int $owner
     * @return void
     */
    public function __construct($scopeName,$resourceType,$owner=null) {
        $this->setId($scopeName);

        $this->setName($scopeName);

        $this->setOwner($resourceType,$owner);
    }

    /**
     * Set the scope id.
     *
     * @param string $scopeName
     * @return void
     */
    protected function setId($scopeName) {
        if($id = \Scope::where('name',$scopeName)->pluck('id')) {
            $this->id = $id;
            return;
        }

        throw new \InvalidArgumentException(sprintf('Scope name "%s" could not be found.',$scopeName));
    }

    /**
     * Set the scope name.
     *
     * @param string $scopeName
     * @return void
     */
    protected function setName($scopeName) {
        if(\Scope::where('name',$scopeName)->count()) {
            $this->name = $scopeName;
            return;
        }

        throw new \InvalidArgumentException(sprintf('Scope name "%s" could not be found.',$scopeName));
    }

    /**
     * Set the scope owner.
     *
     * @param string $resourceType
     * @param int $owner
     * @return void
     */
    protected function setOwner($resourceType,$owner) {
        if(is_null($owner)) {
            $this->owner = $owner;
            return;
        }

        if("\\".$resourceType::where('id',$owner)->count()) {
            $this->owner = $owner;
            return;
        }

        throw new \InvalidArgumentException(sprintf('%s with id %s could not be found.',$resourceType,$owner));
    }

}