<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Search;

interface ISearchFactory
{

	/**
	 * @return Search
	 */
	public function create();

}
