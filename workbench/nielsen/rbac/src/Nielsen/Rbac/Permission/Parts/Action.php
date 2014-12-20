<?php namespace Nielsen\Rbac\Permission\Parts;

class Action {

    public $id;

    public $name;

    public function __construct($actionName=null) {
        if(!is_null($actionName)) {
            $action = self::getAction($actionName);
            $this->setId($action->id);
            $this->setName($action->name);
        }
    }

    protected function setId($id) {
        $this->id = $id;
    }

    protected function setName($name) {
        $this->name = $name;
    }

    protected static function getAction($actionName) {
        $query = \Action::where('name',$actionName);

        if($query->count()) {
            return $query->first();
        }

        throw new \InvalidArgumentException(sprintf('Action "%s" could not be found.',$actionName));
    }

    public static function all() {
        foreach(\Action::orderBy('id','asc')->get() as $result) {
            $action = new self();
            $action->setId($result->id);
            $actions[] = $action;
        }

        return $actions;
    }

    public static function make($actionNames) {
        if($actionNames=='all') {
            return self::all();
        }

        if(is_string($actionNames)) {
            $actionNames = array($actionNames);
        }

        foreach($actionNames as $actionName) {
            $actions[] = new self($actionName);
        }

        return $actions;
    }

}