<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{

    /**
     * Sign-in form factory.
     *
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm()
    {
        $form = $this->factory->create();
        $form->onSuccess[] = function ($form) {
            $form->getPresenter()->redirect('Homepage:');
        };
        return $form;
    }


    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('You have been signed out.');
        $this->redirect('in');
    }

}
