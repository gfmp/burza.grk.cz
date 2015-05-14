<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls;

interface IRegistrationFactory
{

    /**
     * @return Registration
     */
    function create();
}
