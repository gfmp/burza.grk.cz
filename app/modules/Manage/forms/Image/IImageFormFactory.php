<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage\Forms;

interface IImageFormFactory
{

    /**
     * @return ImageForm
     */
    function create();
}
