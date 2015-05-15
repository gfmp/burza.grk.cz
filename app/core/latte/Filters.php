<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Core\Latte;

use App\Model\ORM\Helpers;

final class Filters
{

    /**
     * @param string $filter
     * @param mixed $value
     * @return mixed
     */
    public static function loader($filter, $value)
    {
        if (method_exists(__CLASS__, $filter)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array(array(__CLASS__, $filter), $args);
        }
    }

    /**
     * @param string $s
     * @return string
     */
    public static function price($s)
    {
        return "$s Kč";
    }

    /**
     * @param int $t
     * @return string
     */
    public static function wear($t)
    {
        $types = Helpers::getWears();
        return isset($types[$t]) ? $types[$t] : '-';
    }
}