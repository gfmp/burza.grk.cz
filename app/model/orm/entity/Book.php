<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use App\Model\ORM\Helpers;
use Nette\Utils\DateTime;
use Nextras\Orm\Relationships\ManyHasMany;

/**
 * Book
 *
 * @property Category               $category       {m:1 \App\Model\ORM\Repository\CategoriesRepository $allBooks}
 * @property User                   $user           {m:1 \App\Model\ORM\Repository\UsersRepository}
 * @property Image|NULL             $image          {1:1d \App\Model\ORM\Repository\ImagesRepository primary}
 * @property ManyHasMany|Image[]    $images         {m:n \App\Model\ORM\Repository\ImagesRepository primary}
 * @property string                 $name
 * @property int                    $price
 * @property string                 $description
 * @property int|NULL               $wear
 * @property string|NULL            $author
 * @property string|NULL            $publisher
 * @property int|NULL               $year
 * @property bool                   $active
 * @property string                 $state          {enum self::STATE_*}
 * @property DateTime               $updatedAt      {default now}
 * @property DateTime               $createdAt      {default now}
 * @property-read string            $mainImage      {virtual}
 */
final class Book extends AbstractEntity
{

    /** Book states */
    const STATE_SELLING = 'SELLING';
    const STATE_SOLD = 'SOLD';
    const STATE_EXPIRED = 'EXPIRED';
    const STATE_UNKNOWN = 'UNKNOWN';

    /**
     * @return string
     */
    protected function getterMainImage()
    {
        if ($this->image == NULL) {
            return Helpers::getPlaceholdImage($this->id);
        } else {
            return $this->image->filename;
        }
    }
}
