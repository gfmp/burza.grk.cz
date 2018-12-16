<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Entity;

use Nette\Security\Identity;
use Nette\Utils\DateTime;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * User
 *
 * @property int $id {primary}
 * @property string|NULL          $fbid
 * @property string               $username
 * @property string               $password
 * @property string               $role           {default self::ROLE_USER} {enum self::ROLE_*}
 * @property DateTime             $loggedAt       {default now}
 * @property DateTime             $createdAt      {default now}
 * @property OneHasMany|Book[]    $books          {1:m Book::$user}
 * @property OneHasMany|Message[] $messages       {1:m Message::$user}
 */
final class User extends AbstractEntity
{

	/* User roles */
	const ROLE_ADMIN = 'ADMIN';
	const ROLE_USER  = 'USER';

	/**
	 * @return Identity
	 */
	public function toIdentity()
	{
		return new Identity(
			$this->id,
			strtolower($this->role),
			$this->toArray(self::TO_ARRAY_RELATIONSHIP_AS_ID)
		);
	}

}
