<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Mapper;

use App\Model\ORM\Entity\Book;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Orm\Mapper\Dbal\StorageReflection\UnderscoredStorageReflection;

final class BooksMapper extends AbstractMapper
{

	/**
	 * @return UnderscoredStorageReflection
	 */
	protected function createStorageReflection()
	{
		$reflection = parent::createStorageReflection();
		$reflection->addMapping('createdAt', 'createdAt');
		$reflection->addMapping('updatedAt', 'updatedAt');

		return $reflection;
	}

	/**
	 * @param string $name
	 *
	 * @return QueryBuilder
	 */
	public function findSellingByName($name = NULL)
	{
		$query = $this->builder()->where('state = "' . Book::STATE_SELLING . '"');

		if ($name) {
			$query->andWhere('name LIKE %_like_', $name);
		}

		return $query;
	}

}
