<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM;

final class Helpers
{

	/**
	 * @return array
	 */
	public static function getWears()
	{
		return [
			'0' => 'Nepoužitá',
			'1' => 'Uplně nová',
			'2' => 'Mírně používaná',
			'3' => 'Opotřebovaná',
			'4' => 'Hodně použitá',
			'5' => 'Salát',
			'6' => 'Extra salát',
		];
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getPlaceholdImage($id)
	{
		return sprintf('assets/img/books/book%d.png', ($id % 9) + 1);
	}

}
