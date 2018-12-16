<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Security;

use Nette\Security\Permission;

final class Authorizator extends Permission
{

	/**
	 * Authorizator constructor.
	 */
	public function __construct()
	{
		$this->addRoles();
		$this->addResources();
		$this->addPermissions();
	}

	/**
	 * Add user roles
	 *
	 * @return void
	 */
	protected function addRoles()
	{
		$this->addRole('guest');
		$this->addRole('user', 'guest');
		$this->addRole('admin', 'user');
	}

	/**
	 * Add resources
	 *
	 * @return void
	 */
	protected function addResources()
	{
	}

	/**
	 * Add permissions
	 *
	 * @return void
	 */
	protected function addPermissions()
	{
		// Non logged users
		$this->allow('guest', 'Admin:Sign', ['in', 'password']);

		// Admin permissions
		$this->allow('admin', [
			'Admin:Home',
		], self::ALL);
	}

}
