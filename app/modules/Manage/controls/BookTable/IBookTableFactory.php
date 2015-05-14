<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage\Controls;

use Nextras\Orm\Collection\ICollection;

interface IBookTableFactory
{

    /**
     * @param ICollection $collection
     * @return BookTable
     */
    function create(ICollection $collection);
}
