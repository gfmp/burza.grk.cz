<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Repository;

use App\Model\ORM\Entity\Book;
use App\Model\ORM\Entity\Category;
use Nextras\Orm\Collection\ICollection;

/**
 * Class BooksRepository
 *
 * @method ICollection|Book[] findSellingByName($name)
 *
 * @package App\Model\ORM\Repository
 */
final class BooksRepository extends AbstractRepository
{

	/**
	 * @return ICollection|Book[]
	 */
	public function findSelling()
	{
		return $this->findBy(['state' => Book::STATE_SELLING]);
	}

	/**
	 * @return ICollection|Book[]
	 */
	public function findArchived()
	{
		return $this->findBy(['state' => Book::STATE_ARCHIVED]);
	}

	/**
	 * @return ICollection|Book[]
	 */
	public function findExpired()
	{
		return $this->findBy(['state' => Book::STATE_EXPIRED]);
	}

	/**
	 * @return ICollection|Book[]
	 */
	public function findSold()
	{
		return $this->findBy(['state' => Book::STATE_SOLD]);
	}

	/**
	 * @param ICollection|Category[] $categories
	 *
	 * @return array
	 */
	public function countSellingByCategories(ICollection $categories)
	{
		$result = [];

		foreach ($categories as $category) {
			$result[$category->id] = $this->findBy(['state' => Book::STATE_SELLING, 'category' => $category])->count();
		}

		return $result;
	}

}
