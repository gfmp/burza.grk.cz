<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Category;

interface ICategoryFactory
{

    /**
     * @return Category
     */
    function create();
}
