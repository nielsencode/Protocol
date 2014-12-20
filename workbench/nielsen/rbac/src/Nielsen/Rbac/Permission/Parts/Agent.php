<?php namespace Nielsen\Rbac\Permission\Parts;

class Agent {

    public $type;

    public $id;

    public function __construct($agent) {
        $agent = self::getAgent($agent);

        $this->setType(get_class($agent));
        $this->setId($agent->id);
    }

    protected static function getAgent($agent) {
        if(is_string($agent)) {
            $agent = self::getRole($agent);
        }

        elseif(get_class($agent)!='User') {
            throw new \InvalidArgumentException('Agent must be a role name or instance of User.');
        }

        return $agent;
    }

    protected static function getRole($roleName) {
        $query = \Role::where('name',$roleName);

        if($query->count()) {
            return $query->first();
        }

        throw new \InvalidArgumentException(sprintf('Role "%s" could not be found.',$roleName));
    }

    protected function setType($type) {
        $this->type = $type;
    }

    protected function setId($id) {
        $this->id = $id;
    }

    public function roleId() {
        if($this->type=='User') {
            return \User::where('id',$this->id)->pluck('role_id');
        }

        return null;
    }

}