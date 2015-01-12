<?php namespace Nielsen\Rbac\Commands;

use Illuminate\Console\Command;

class Reset extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rbac:reset';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove all permissions.';

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
		foreach(\Permission::all() as $permission) {
			$permission->delete();
		}

		$this->info('Permissions reset.');
	}

}
