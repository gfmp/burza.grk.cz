<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use Nette\Utils\DateTime;
use Nextras\Orm\Relationships\ManyHasMany;

/**
 * Image
 *
 * @property int $id {primary}
 * @property string             $filename
 * @property DateTime           $createdAt            {default now}
 * @property Book|NULL          $book                 {1:1 Book::$image}
 * @property ManyHasMany|Book[] $books                {m:n Book::$images}
 */
final class Image extends AbstractEntity
{

}
