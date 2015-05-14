<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls;

use Nextras\Orm\Collection\ICollection;

interface ICategoryFactory
{

    /**
     * @return Category
     */
    function create();
}
