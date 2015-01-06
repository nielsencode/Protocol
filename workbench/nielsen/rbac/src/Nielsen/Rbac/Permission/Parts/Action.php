<?php namespace Nielsen\Rbac\Permission\Parts;

class Action {

    /**
     * The action id.
     *
     * @var int
     */
    public $id;

    /**
     * The action name.
     *
     * @var string
     */
    public $name;

    /**
     * Create a new action instance.
     *
     * @param string $actionName
     * @return void
     */
    public function __construct($actionName=null) {
        if(is_null($actionName)) {
            return;
        }

        $action = self::getAction($actionName);

        $this->setId($action->id);

        $this->setName($action->name);
    }

    /**
     * Set the action id.
     *
     * @param int $id
     * @return void
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * Set the action name.
     *
     * @param string $name
     * @return void
     */
    protected function setName($name) {
        $this->name = $name;
    }

    /**
     * Get action DB model instance.
     *
     * @param $actionName
     * @return \Action
     */
    protected static function getAction($actionName) {
        $query = \Action::where('name',$actionName);

        if($query->count()) {
            return $query->first();
        }

        throw new \InvalidArgumentException(sprintf('Action "%s" could not be found.',$actionName));
    }

    /**
     * Return an array containing instances for all actions.
     *
     * @return array
     */
    public static function all() {
        foreach(\Action::orderBy('id','asc')->get() as $result) {
            $action = new self();
            $action->setId($result->id);
            $actions[] = $action;
        }

        return $actions;
    }

    /**
     * Return an array containing instances for the given actions.
     *
     * @param mixed $actionNames
     * @return array
     */
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