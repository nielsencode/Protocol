<?php namespace Nielsen\Rbac\Permission;

class Query {

	protected $negotiation;

	protected $selectStatement = "
		SELECT *,
			GROUP_CONCAT(
				action_permission.action_id
				ORDER BY action_permission.action_id
				ASC
			)
			AS actions
			FROM permissions
			JOIN action_permission
			ON action_permission.permission_id=permissions.id
			WHERE (
				(
					agent_type=:agent_type
					AND agent_id=:agent_id
				)
				OR (
					agent_type='Role'
					AND agent_id=:role_id
				)
			)
			AND resource_type=:resource_type
			AND resource_id%s
			AND scope_id%s
			GROUP BY permissions.id
			HAVING actions LIKE :actions
	";

	public function __construct(Negotiation $negotiation) {
		$this->setNegotiation($negotiation);
	}

	public function setNegotiation($negotiation) {
		$this->negotiation = $negotiation;
	}

	public function bindings($statement,$values) {
		preg_match_all('/:(\w+)/',$statement,$matches,PREG_PATTERN_ORDER);

		foreach($matches[1] as $match) {
			$bindings[] = $values[$match];
		}

		return $bindings;
	}

	public function resourceType() {
		$queryValues = $this->negotiation->queryValues();

		$type = $this->selectStatement;

		$args = array(
			" IS NULL"
		);

		for($i=0; $i<count($this->negotiation->scopes); $i++) {
			$values[] = ":scope_id_$i";
		}

		$args[] = " IN (".implode(',',$values).")";

		$type = vsprintf($type,$args);

		$result = \DB::select(\DB::raw($type),$this->bindings($type,$queryValues));

		return !empty($result) ? $result[0] : false;
	}

	public function singleResource() {
		$queryValues = $this->negotiation->queryValues();

		$single = $this->selectStatement;

		$args = array(
			'=:resource_id',
			' IS NULL'
		);

		$single = vsprintf($single,$args);

		$result = \DB::select(\DB::raw($single),$this->bindings($single,$queryValues));

		return !empty($result) ? $result[0] : false;
	}

	protected function delete() {
		$queryValues = $this->negotiation->queryValues();

		$delete = "
			DELETE
			FROM permissions
			WHERE (
				(agent_type=:agent_type AND agent_id=:agent_id)
				%s
			)
			AND resource_type=:resource_type
			AND resource_id%s
			%s
		";

		$args = array(
			$queryValues['role_id'] ? "(agent_type='Role' AND agent_id=:role_id)" : '',
			$queryValues['resource_id'] ? "=:resource_id" : " IS NULL",
			''
		);

		$delete = vsprintf($delete,$args);

		\DB::statement(\DB::raw($delete),$this->bindings($delete,$queryValues));
	}

	protected function insert() {
		$queryValues = $this->negotiation->queryValues();

		$insert = "
			INSERT
			INTO permissions
			(agent_type,agent_id,resource_type,resource_id,scope_id)
			VALUES (:agent_type,:agent_id,:resource_type,:resource_id,:scope_id)
		";

		\DB::statement(\DB::raw($insert),$this->bindings($insert,$queryValues));
	}

	protected function actions() {
		$actions = "
			INSERT
			INTO action_permission
			(action_id,permission_id)
			VALUES %s
		";

		for($i=0; $i<count($this->negotiation->actions); $i++) {
			$values[] = "(:action_id_$i,:permission_id_$i)";
		}

		$actions = sprintf($actions,implode(',',$values));

		$permission_id = \DB::getPdo()->lastInsertId();

		foreach($this->negotiation->actions as $action) {
			$bindings[] = $action->id;
			$bindings[] = $permission_id;
		}

		\DB::statement(\DB::raw($actions),$bindings);
	}

	public function grant() {
		$this->delete();
		$this->insert();
		$this->actions();
	}

}