<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Common\Controls;

interface ICategoryFactory
{

    /**
     * @return Category
     */
    function create();
}