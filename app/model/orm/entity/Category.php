<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * Category
 *
 * @property string                 $name
 * @property string                 $slug
 * @property OneHasMany|Book[]      $allBooks   {1:m Book}
 * @property ICollection|Book[]     $books      {virtual}
 */
final class Category extends AbstractEntity
{

    /**
     * @return ICollection
     */
    protected function getterBooks()
    {
        return $this->allBooks->get()->findBy(['active' => TRUE]);
    }
}
