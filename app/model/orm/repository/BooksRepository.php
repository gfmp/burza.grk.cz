<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Repository;

use Nextras\Orm\Collection\ICollection;

final class BooksRepository extends AbstractRepository
{

    /**
     * @return ICollection
     */
    public function findActive()
    {
        return $this->findBy(['active' => TRUE]);
    }

    /**
     * @return ICollection
     */
    public function findInactive()
    {
        return $this->findBy(['active' => FALSE]);
    }
}
