<?php namespace Nielsen\Rbac\Permission\Parts;

class Resource {

    public $type;

    public $id;

    public function __construct($type,$id=null) {
        $this->model($type);

        $this->setType($type);
        $this->setId($id);
    }

    protected function setType($type) {
        $this->type = $type;
    }

    protected function setId($id) {
        $this->id = $id;
    }

    /*protected function exists($type,$id) {
        $class = $this->model($type);

        if(!$class::where('id',$id)->count()) {
            throw new \InvalidArgumentException(sprintf('Could not find "%s" with id "%u".',$type,$id));
        }

        return true;
    }*/

    protected function model($modelName) {
        $class = "\\$modelName";

        if(get_parent_class($class)=='Illuminate\\Database\\Eloquent\\Model') {
            return $class;
        }

        throw new \InvalidArgumentException(sprintf('Model "%s" could not be found.',$modelName));
    }

    public function make($scopeName,$scopeOwner) {
        $classname = \Config::get('rbac::resource')."\\{$this->type}";
        return new $classname($scopeName,$scopeOwner);
    }

}