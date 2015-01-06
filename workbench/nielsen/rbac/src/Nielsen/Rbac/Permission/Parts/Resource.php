<?php namespace Nielsen\Rbac\Permission\Parts;

class Resource {

    /**
     * The resource type.
     *
     * @var string
     */
    public $type;

    /**
     * The resource id.
     *
     * @var int
     */
    public $id;

    /**
     * Create a new resource instance.
     *
     * @param string $type
     * @param int $id
     * @return void
     */
    public function __construct($type,$id=null) {
        $this->modelExists($type);

        $this->setType($type);

        $this->setId($id);
    }

    /**
     * Set the resource type.
     *
     * @param string $type
     * @return void
     */
    protected function setType($type) {
        $this->type = $type;
    }

    /**
     * Set the resource id.
     *
     * @param int $id
     * @return void
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * Check if a DB model for the resource exists.
     *
     * @param string $modelName
     * @return bool
     */
    protected function modelExists($modelName) {
        $class = "\\$modelName";

        if(get_parent_class($class)=='Illuminate\\Database\\Eloquent\\Model') {
            return true;
        }

        throw new \InvalidArgumentException(sprintf('Model "%s" could not be found.',$modelName));
    }

    /**
     * Generate a resource model instance.
     *
     * @param string $scopeName
     * @param int $scopeOwner
     * @return \Nielsen\Rbac\Resource\ResourceType;
     */
    public function make($scopeName,$scopeOwner) {
        $classname = \Config::get('rbac::resources')."\\{$this->type}";
        return new $classname($scopeName,$scopeOwner);
    }

}