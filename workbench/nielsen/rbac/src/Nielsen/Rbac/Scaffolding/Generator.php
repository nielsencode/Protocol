<?php namespace Nielsen\Rbac\Scaffolding;

use Psr\Log\InvalidArgumentException;
use Symfony\Component\Process\Exception\LogicException;

class Generator {

    /**
     * The template.
     *
     * @var string
     */
    protected $template;

    /**
     * The savepath.
     *
     * @var string
     */
    protected $savepath;

    /**
     * The template bindings.
     *
     * @var array
     */
    protected $bindings;

    /**
     * Create a new generator instance.
     *
     * @param string $template
     * @param string $savepath
     * @return void
     */
    public function __construct($template,$savepath) {
        $this->setTemplate($template);
        $this->setSavepath($savepath);
    }

    /**
     * Set the template.
     *
     * @param string $template
     * @return void
     */
    protected function setTemplate($template) {
        $this->template = file_get_contents(__DIR__."/templates/$template.txt");
    }

    /**
     * Set the savepath.
     *
     * @param string $savepath
     * @return void
     */
    protected function setSavepath($savepath) {
        $this->savepath = $savepath;
    }

    /**
     * Get the template vars.
     *
     * @return array
     */
    protected function getTemplateVars() {
        preg_match_all('/\{\{ ?\$(\w+) ?\}\}/',$this->template,$matches,PREG_PATTERN_ORDER);
        return $matches;
    }

    /**
     * Set the bindings.
     *
     * @param array $bindings
     */
    public function setBindings(array $bindings) {
        $templateVars = $this->getTemplateVars()[1];

        $diff = array_values(array_diff($templateVars,array_keys($bindings)));

        if(!$diff) {
            $this->bindings = $bindings;
            return;
        }

        throw new LogicException(sprintf('Could not find binding "$%s"',$diff[0]));
    }

    /**
     * Bind the bindings to the template.
     *
     * @return void
     */
    protected function bindTemplate() {
        $templateVars = $this->getTemplateVars();

        $search = $templateVars[0];

        foreach($templateVars[1] as $var) {
            $replace[] = $this->bindings[$var];
        }

        $this->template = str_replace($search,$replace,$this->template);
    }

    /**
     * Run the generator & generate a new template instance.
     *
     * @return void
     */
    public function run() {
        $this->bindTemplate();
        file_put_contents($this->savepath,$this->template);
    }

}