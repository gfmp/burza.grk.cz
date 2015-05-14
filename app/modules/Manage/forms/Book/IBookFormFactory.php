<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage\Forms;

interface IBookFormFactory
{

    /**
     * @return BookForm
     */
    function create();
}
