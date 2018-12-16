<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\BookList;

use Nextras\Orm\Collection\ICollection;

interface IBookListFactory
{

	/**
	 * @param ICollection $collection
	 *
	 * @return BookList
	 */
	public function create(ICollection $collection);

}
