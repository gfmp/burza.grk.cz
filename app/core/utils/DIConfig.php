<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Core\Utils;

use Nette\DI\Helpers;
use Nette\Utils\Arrays;

/**
 * System container parameters holder
 */
final class DIConfig
{

    /** @var array */
    private $parameters;

    /**
     * @param array $parameters
     */
    private function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = NULL)
    {
        if (func_num_args() > 1) {
            return Arrays::get($this->parameters, $name, $default);
        } else {
            return Arrays::get($this->parameters, $name);
        }
    }

    /**
     * @param string $name
     * @param boolean $recursive
     * @return mixed
     */
    public function expand($name, $recursive = FALSE)
    {
        return Helpers::expand("%$name%", $this->parameters, $recursive);
    }

    /**
     * FACTORY *****************************************************************
     * *************************************************************************
     */

    /**
     * @param array $parameters
     */
    public static function factory(array $parameters)
    {
        return new self($parameters);
    }

}
