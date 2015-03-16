<?php namespace Nielsen\Rbac\Commands;

use Illuminate\Console\Command;
use App;
use Action;

class Permissions extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rbac:permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all permissions.';

	protected $string = '%s has %s%s over %s%s';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->actions = Action::orderBy('id','asc')->lists('name');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->listPermissions();
	}

	protected function output($permission) {
		$actions = $permission->actions()->orderBy('id','asc')->lists('name');

		$values = [
			ucfirst($permission->agent_type=='Role'
				? \Role::find($permission->agent_id)->name
				: \User::find($permission->agent_id)->name())
		];

		foreach($this->actions as $action) {
			$values[] = in_array($action,$actions) ? $action : '-';
		}

		$values = array_merge($values,[
			$permission->scope ? $permission->scope->name : '',
			$permission->resource_type,
			$permission->resource_id ? " {$permission->resource_id}" : ''
		]);

		return $values;
	}

	protected function listPermissions() {
		$table = App::make('\cli\Table');

		$headers = array_merge(
			['agent'],
			$this->actions,
			[
				'scope',
				'resource type',
				'resource id'
			]
		);

		$table->setHeaders(array_map('ucfirst',$headers));

		$permissions = \Permission::with('scope')
			->orderBy('agent_type')
			->orderBy('agent_id')
			->orderBy('resource_type')
			->orderBy('resource_id')
			->orderBy('scope_id')
			->get();

		foreach($permissions as $i=>$permission) {
			$table->addRow($this->output($permission));

			if(isset($permissions[$i+1])) {
				$next = $permissions[$i+1];

				if(
					$next->agent_type != $permission->agent_type ||
					$next->agent_id != $permission->agent_id
				) {
					$table->addRow(array_fill(0,count($headers),''));
				}
			}
		}

		$this->info($table->display());
	}

}
