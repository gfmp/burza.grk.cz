<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Forms;

interface IImageFormFactory
{

	/**
	 * @return ImageForm
	 */
	public function create();

}
