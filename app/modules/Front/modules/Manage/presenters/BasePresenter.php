<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage;

use App\Front\BasePresenter as FrontBasePresenter;
use Nette\Application\ForbiddenRequestException;

/**
 * Base presenter for all manage presenters
 */
abstract class BasePresenter extends FrontBasePresenter
{

	/**
	 * @param mixed $element
	 *
	 * @throws ForbiddenRequestException
	 * @return void
	 */
	public function checkRequirements($element)
	{
		parent::checkRequirements($element);

		if (!$this->user->isLoggedIn()) {
			$this->flashMessage('Pro vstup do této sekce musíte být přihlášen(a).', 'warning');
			$this->redirect(':Front:Sign:in');
		}
	}

}
