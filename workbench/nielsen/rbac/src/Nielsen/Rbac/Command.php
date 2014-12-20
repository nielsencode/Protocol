<?php namespace Nielsen\Rbac;

use File;

class Command {

    protected static $namespace = 'Nielsen\Rbac\Commands';

    protected static $prefix = 'command.rbac';

    public $path;

    public $command;

    public function __construct($filename) {
        $this->setPath($filename);
        $this->setCommand($filename);
    }

    protected function setPath($filename) {
        $this->path = self::$namespace."\\$filename";
    }

    protected function setCommand($filename) {
        $this->command = self::$prefix.".".strtolower($filename);
    }

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