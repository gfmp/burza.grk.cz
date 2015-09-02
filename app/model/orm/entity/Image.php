<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use Nette\Utils\DateTime;
use Nextras\Orm\Relationships\ManyHasMany;

/**
 * Image
 *
 * @property string $filename
 * @property DateTime $createdAt            {default now}
 * @property Book|NULL $book                {1:1d Book}
 * @property ManyHasMany|Book[] $books      {m:1 Book}
 */
final class Image extends AbstractEntity
{

}
