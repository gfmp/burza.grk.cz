<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\IRegistrationFactory;
use App\Front\Controls\Registration;
use App\Model\ORM\Entity\User;

/**
 * Sign in/out presenters.
 */
final class SignPresenter extends BasePresenter
{

    /** @var IRegistrationFactory @inject */
    public $registrationFactory;


    /**
     * SIGN IN/OUT *************************************************************
     * *************************************************************************
     */

    /**
     * Logout
     */
    public function actionOut()
    {
        $this->user->logout(TRUE);
        $this->flashMessage('Byl(a) jste úspěšně odhlášen(a).', 'success');
        $this->redirect(':Front:Home:');
    }

    /**
     * REGISRATION *************************************************************
     * *************************************************************************
     */

    /**
     * Sign up
     */
    public function actionUp()
    {
    }

    /**
     * Registration control factory.
     *
     * @return Registration
     */
    protected function createComponentRegistration()
    {
        $registration = $this->registrationFactory->create();

        $registration->onRegistration[] = function (User $user) {
            // Display info
            $this->flashMessage('Děkujeme za registraci. V sekci můj účet můžete nastavit vše nezbytné.', 'success');

            // Autologin
            $this->user->login($user->toIdentity());

            // Redirect to profile
            $this->redirect(':Manage:Profile:');
        };

        return $registration;
    }
}
