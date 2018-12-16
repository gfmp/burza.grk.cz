<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Repository;

use Inflect\Inflect;
use Nextras\Orm\Repository\Repository;

abstract class AbstractRepository extends Repository
{

	/**
	 * @return array
	 */
	public static function getEntityClassNames()
	{
		$class = str_replace('App\Model\ORM\Repository', 'App\Model\ORM\Entity', get_called_class());
		$class = str_replace('Repository', NULL, $class);

		return [Inflect::singularize($class)];
	}

}
