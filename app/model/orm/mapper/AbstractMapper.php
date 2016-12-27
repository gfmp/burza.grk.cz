<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Mapper;

use Inflect\Inflect;
use Nextras\Orm\Mapper\Mapper;

abstract class AbstractMapper extends Mapper
{

	/**
	 * @return string
	 */
	public function getTableName()
	{
		if (!$this->tableName) {
			$class           = str_replace('App\Model\ORM\Mapper\\', NULL, get_called_class());
			$class           = str_replace('Mapper', NULL, $class);
			$class           = strtolower($class);
			$this->tableName = Inflect::singularize($class);
		}

		return $this->tableName;
	}

}
