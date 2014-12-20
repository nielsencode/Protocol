<?php namespace Nielsen\Rbac\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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

	protected $string = '%s %s has %s%s over %s%s';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
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
		$actions = $permission->actions()->orderBy('id','asc')->get();

		$args = array(
			$permission->agent_type,
			$permission->agent_id,
			implode(',',array_map(function($v) {return $v['name'];},$actions->toArray())),
			$permission->scope ? " of scope {$permission->scope->name}" : '',
			$permission->resource_type,
			$permission->resource_id ? " {$permission->resource_id}" : ''
		);

		return vsprintf($this->string,$args);
	}

	protected function listPermissions() {

		$permissions = \Permission::with('scope')
			->orderBy('agent_type')
			->orderBy('agent_id')
			->orderBy('resource_type')
			->orderBy('resource_id')
			->orderBy('scope_id')
			->get();

		foreach($permissions as $permission) {
			$this->info($this->output($permission));
		}
	}

}
