<?php namespace Nielsen\Rbac\Permission\Parts;

use Illuminate\Database\Eloquent\Model;

class Agent {

    /**
     * The agent type.
     *
     * @var string
     */
    public $type;

    /**
     * The agent id.
     *
     * @var int
     */
    public $id;

    /**
     * Create a new agent instance.
     *
     * @param mixed $agent
     * @return void
     */
    public function __construct($agent) {
        $agent = self::getAgent($agent);

        $this->setType(get_class($agent));
        $this->setId($agent->id);
    }

    /**
     * Get agent DB model instance.
     *
     * @param mixed $agent
     * @return Model
     */
    protected static function getAgent($agent) {
        if(is_string($agent)) {
            $agent = self::getRole($agent);
        }

        elseif(get_class($agent)!='User') {
            throw new \InvalidArgumentException('Agent must be a role name or instance of User.');
        }

        return $agent;
    }

    /**
     * Get role DB model instance.
     *
     * @param string $roleName
     * @return \Role
     */
    protected static function getRole($roleName) {
        $query = \Role::where('name',$roleName);

        if($query->count()) {
            return $query->first();
        }

        throw new \InvalidArgumentException(sprintf('Role "%s" could not be found.',$roleName));
    }

    /**
     * Set the agent type.
     *
     * @param string $type
     * @return void
     */
    protected function setType($type) {
        $this->type = $type;
    }

    /**
     * Set the agent id.
     *
     * @param int $id
     * @return void
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * Get the role id for the agent if the agent is a user.
     *
     * @return mixed
     */
    public function roleId() {
        if($this->type=='User') {
            return \User::where('id',$this->id)->pluck('role_id');
        }

        return null;
    }

}