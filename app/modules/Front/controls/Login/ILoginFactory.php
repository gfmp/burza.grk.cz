<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Login;

interface ILoginFactory
{

	/**
	 * @return Login
	 */
	public function create();

}
