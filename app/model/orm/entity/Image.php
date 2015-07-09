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
 * @property Book|NULL $book                {1:1d \App\Model\ORM\Repository\BooksRepository $image}
 * @property ManyHasMany|Book[] $books      {m:n \App\Model\ORM\Repository\BooksRepository $images}
 */
final class Image extends AbstractEntity
{

}
