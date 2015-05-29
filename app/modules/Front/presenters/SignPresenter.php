<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\IRegistrationFactory;
use App\Front\Controls\Registration;
use App\Model\Facebook\FacebookService;
use App\Model\ORM\Entity\User;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\UsersRepository;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Nette\Application\Responses\RedirectResponse;

/**
 * Sign in/out presenters.
 */
final class SignPresenter extends BasePresenter
{

    /** @var IRegistrationFactory @inject */
    public $registrationFactory;

    /** @var FacebookService @inject */
    public $facebook;

    /** @var UsersRepository */
    private $usersRepository;

    /**
     * @param Orm $orm
     */
    public function injectOrm(Orm $orm)
    {
        $this->usersRepository = $orm->users;
    }

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
            $this->redirect(':Manage:Profile:');
        };

        return $registration;
    }

    /**
     * Redirect to facebook
     */
    public function actionFacebook()
    {
        $helper = $this->facebook->createLoginHelper($this->link('//facebookAuthorize'));
        $this->sendResponse(new RedirectResponse($helper->getLoginUrl(['email', 'public_profile'])));
    }

    /**
     * Resolve facebook redirect
     */
    public function actionFacebookAuthorize()
    {
        // Authorization failed
        if ($this->getParameter('error_code')) {
            $this->flashMessage('Nepodařilo se vás přihlasít pomocí facebooku. Musíte se u nás zaregistrovat ručně.', 'danger');
            $this->redirect('up');
            return;
        }

        try {
            // Get session from response
            $helper = $this->facebook->createLoginHelper($this->link('//facebookAuthorize'));
            $session = $helper->getSessionFromRedirect();

            // Retrieving session failed
            if (!$session) {
                throw new FacebookAuthorizationException('Přihlášení selhalo. Kontaktujte správce.', NULL, 800);
            }
        } catch (FacebookSDKException $ex) {
            $this->flashMessage($ex->getMessage(), 'danger');
            $this->redirect('up');
        }

        // Request user details
        $request = new FacebookRequest($session, 'GET', '/me');
        $response = $request->execute();
        $me = $response->getGraphObject();

        // Create registration component
        $registration = $this->registrationFactory->create();
        $registration->onRegistration[] = function (User $user, $registered) {
            if ($registered) {
                // Display info
                $this->flashMessage('Děkujeme za registraci přes Facebook. V sekci můj účet můžete nastavit vše nezbytné.', 'success');
            }

            // Autologin
            $this->user->login($user->toIdentity());

            // Redirect to profile
            $this->redirect(':Manage:Profile:');
        };

        $registration->processFacebook($me);
    }

}
