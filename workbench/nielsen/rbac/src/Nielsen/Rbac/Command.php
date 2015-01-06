<?php namespace Nielsen\Rbac;

use File;

class Command {

    /**
     * Namespace corresponding to the commands folder.
     *
     * @var string
     */
    protected static $namespace = 'Nielsen\Rbac\Commands';

    /**
     * The command prefix.
     *
     * @var string
     */
    protected static $prefix = 'command.rbac';

    /**
     * The path.
     *
     * @var string
     */
    public $path;

    /**
     * The command name
     *
     * @var string
     */
    public $command;

    /**
     * Create a new command instance.
     *
     * @param string $filename
     * @return void
     */
    public function __construct($filename) {
        $this->setPath($filename);
        $this->setCommand($filename);
    }

    /**
     * Set the path.
     *
     * @param string $filename
     * @return void
     */
    protected function setPath($filename) {
        $this->path = self::$namespace."\\$filename";
    }

    /**
     * Set the command name.
     *
     * @param string $filename
     * @return void
     */
    protected function setCommand($filename) {
        $this->command = self::$prefix.".".strtolower($filename);
    }

    /**
     * Return an array of instances for all commands.
     *
     * @return array
     */
    public static function allCommands() {
        foreach(File::allFiles(__DIR__."/Commands") as $file) {
            $filename = $file->getBasename('.php');

            if($filename!='Scaffold') {
                $commands[] = new self($file->getBasename('.php'));
            }
        }

        return $commands;
    }

}