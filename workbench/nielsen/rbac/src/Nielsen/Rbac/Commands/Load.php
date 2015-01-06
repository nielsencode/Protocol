<?php namespace Nielsen\Rbac\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Rbac;

class Load extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rbac:load';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load permissions from file.';

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
		$file = $this->argument('path');

		require base_path()."/$file";

		$this->info('Permissions loaded.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('path', InputArgument::REQUIRED, 'Path to permissions file.'),
		);
	}

}
