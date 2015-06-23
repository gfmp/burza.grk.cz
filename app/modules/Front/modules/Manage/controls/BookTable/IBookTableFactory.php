<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Controls\BookTable;

use Nextras\Orm\Collection\ICollection;

interface IBookTableFactory
{

    /**
     * @param ICollection $collection
     * @return BookTable
     */
    function create(ICollection $collection);
}
