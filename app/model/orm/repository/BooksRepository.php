<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Repository;

use App\Model\ORM\Entity\Book;
use Nextras\Orm\Collection\ICollection;

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

}
