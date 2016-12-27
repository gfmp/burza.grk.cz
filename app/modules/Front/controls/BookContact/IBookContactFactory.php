<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\BookContact;

use App\Model\ORM\Entity\Book;

interface IBookContactFactory
{

	/**
	 * @param Book $book
	 *
	 * @return BookContact
	 */
	public function create(Book $book);

}
