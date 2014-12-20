<?php namespace Nielsen\Rbac\Scaffolding;

use Psr\Log\InvalidArgumentException;
use Symfony\Component\Process\Exception\LogicException;

class Generator {

    protected $template;

    protected $savepath;

    protected $bindings;

    public function __construct($template,$savepath) {
        $this->setTemplate($template);
        $this->setSavepath($savepath);
    }

    protected function setTemplate($template) {
        $this->template = file_get_contents(__DIR__."/templates/$template.txt");
    }

    protected function setSavepath($savepath) {
        $this->savepath = $savepath;
    }

    protected function getTemplateVars() {
        preg_match_all('/\{\{ ?\$(\w+) ?\}\}/',$this->template,$matches,PREG_PATTERN_ORDER);
        return $matches;
    }

    public function setBindings(array $bindings) {
        $templateVars = $this->getTemplateVars()[1];

        $diff = array_values(array_diff($templateVars,array_keys($bindings)));

        if(!$diff) {
            $this->bindings = $bindings;
            return;
        }

        throw new LogicException(sprintf('Could not find binding "$%s"',$diff[0]));
    }

    protected function bindingStrings() {
        return array_map(function($v) {
            return "{{".$v."}}";
        },$this->bindings);
    }

    protected function bindTemplate() {
        $templateVars = $this->getTemplateVars();

        $search = $templateVars[0];

        foreach($templateVars[1] as $var) {
            $replace[] = $this->bindings[$var];
        }

        $this->template = str_replace($search,$replace,$this->template);
    }

    public function run() {
        $this->bindTemplate();
        file_put_contents($this->savepath,$this->template);
    }

}