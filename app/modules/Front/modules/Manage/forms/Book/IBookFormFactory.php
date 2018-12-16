<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Forms;

interface IBookFormFactory
{

	/**
	 * @return BookForm
	 */
	public function create();

}
