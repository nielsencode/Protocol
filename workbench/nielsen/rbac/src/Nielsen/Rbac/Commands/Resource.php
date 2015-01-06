<?php namespace Nielsen\Rbac\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Nielsen\Rbac\Scaffolding\Generator;

class Resource extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rbac:resource';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new resource.';

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
		$name = $this->argument('name');

		$savepath = \Config::get('rbac::resource_path')."/$name.php";

		$generator = new Generator('resourcetype',$savepath);

		$generator->setBindings(array(
			'namespace'=>\Config::get('rbac::resources'),
			'classname'=>$name
		));

		$generator->run();

		$this->info('resource created successfully.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Resource name.'),
		);
	}

}
