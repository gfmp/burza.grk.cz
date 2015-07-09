<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\Registration\IRegistrationFactory;
use App\Front\Controls\Registration\Registration;
use App\Model\Facebook\FacebookService;
use App\Model\ORM\Entity\User;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\UsersRepository;
use App\Model\Security\FacebookAuthenticator;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSDKException;
use Nette\Application\Responses\RedirectResponse;
use Nette\Security\AuthenticationException;

/**
 * Sign in/out presenters.
 */
final class SignPresenter extends BasePresenter
{

    /** @var IRegistrationFactory @inject */
    public $registrationFactory;

    /** @var FacebookService @inject */
    public $facebook;

    /** @var FacebookAuthenticator @inject */
    public $facebookAuthenticator;

    /** @var UsersRepository @inject */
    public $usersRepository;

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
     * REGISTRATION ************************************************************
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
            $this->redirect(':Front:Manage:Profile:');
        };

        $registration->onError[] = function ($message) {
            $this->flashMessage($message, 'danger');
            $this->redirect('this');
        };

        return $registration;
    }

    /**
     * Redirect to facebook
     */
    public function actionFacebook()
    {
        $this->checkLoginRequirements();
        $helper = $this->facebook->createLoginHelper($this->link('//facebookAuthorize'));
        $this->sendResponse(new RedirectResponse($helper->getLoginUrl(['email', 'public_profile'])));
    }

    /**
     * Resolve facebook redirect
     */
    public function actionFacebookAuthorize()
    {
        $this->checkLoginRequirements();

        // Authorization failed
        if ($this->getParameter('error_code')) {
            $this->flashMessage('Nepodařilo se vás přihlásit pomocí facebooku. Musíte se u nás zaregistrovat ručně.', 'danger');
            $this->redirect('up');
            return;
        }

        try {
            // Get session from response
            $helper = $this->facebook->createLoginHelper($this->link('//facebookAuthorize'));
            $session = $helper->getSessionFromRedirect();

            // Retrieving session failed
            if (!$session) {
                throw new FacebookAuthorizationException('Přihlášení selhalo. Kontaktujte správce nebo se registrujte ručně.', NULL, 800);
            }

            // Retrieve user
            $user = $this->facebook->createUserFromSession($session);

            // Try login
            $this->user->setAuthenticator($this->facebookAuthenticator);
            $this->user->login($user);

            // Display info
            $this->flashMessage('Systém vás přihlásil přes Facebook.', 'success');
            $this->redirect('Home:');
        } catch (FacebookSDKException $ex) {
            $this->flashMessage($ex->getMessage(), 'danger');
            $this->redirect('up');
        } catch (AuthenticationException $ex) {
            $this->flashMessage($ex->getMessage(), 'danger');
            $this->redirect('up');
        }
    }

    /**
     * @return void
     */
    private function checkLoginRequirements()
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect('Home:');
        }
    }

}
