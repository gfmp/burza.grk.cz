<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Mapper;

use Nextras\Orm\Mapper\Dbal\StorageReflection\UnderscoredStorageReflection;

final class UsersMapper extends AbstractMapper
{

	/**
	 * @return UnderscoredStorageReflection
	 */
	protected function createStorageReflection()
	{
		$reflection = parent::createStorageReflection();
		$reflection->addMapping('loggedAt', 'loggedAt');
		$reflection->addMapping('createdAt', 'createdAt');

		return $reflection;
	}

}
