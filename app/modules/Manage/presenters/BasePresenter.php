<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage;

use App\Common\BasePresenter as CommonBasePresenter;
use Nette\Application\ForbiddenRequestException;

/**
 * Base presenter for all manage presenters
 */
abstract class BasePresenter extends CommonBasePresenter
{

    /**
     * @param $element
     * @throws ForbiddenRequestException
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
