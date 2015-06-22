<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Entity\User;
use App\Model\ORM\Repository\UsersRepository;
use Facebook\GraphObject;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;
use Nette\Security\User as UserSecurity;
use Tracy\Debugger;

/**
 * Registration
 *
 * @method onRegistration(User $user, bool $registered)
 */
final class Registration extends BaseControl
{

    /** @var array */
    public $onRegistration = [];

    /** @var UsersRepository */
    private $repository;

    /** @var UserSecurity */
    private $user;

    /**
     * @param UsersRepository $repository
     * @param UserSecurity $user
     */
    public function __construct(UsersRepository $repository, UserSecurity $user)
    {
        $this->repository = $repository;
        $this->user = $user;
    }

    /**
     * Create login form
     *
     * @return Form
     */
    protected function createComponentForm()
    {
        $form = new Form();

        $form->addText('username', 'Uživatelské jméno')
            ->setAttribute('autofocus')
            ->setRequired('Uživatelské jméno je povinné!')
            ->addRule($form::EMAIL, 'Vyplňte prosím email ve správném formátu.');

        $form->addPassword('password1', 'Heslo')
            ->setRequired('Heslo musí být vyplněno!');

        $form->addPassword('password2', 'Kontrola hesla')
            ->setRequired('Kontrola hesla musí být vyplněna!')
            ->addRule($form::EQUAL, 'Hesla musí být stejná.', $form['password1']);

        $form->addSubmit('send', 'Zaregistrovat');

        $form->onValidate[] = [$this, 'validateForm'];
        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    /**
     * Validate form
     *
     * @param Form $form
     */
    public function validateForm(Form $form)
    {
        $values = $form->getValues();

        $user = $this->repository->getBy(['username' => $values->username]);
        if ($user) {
            $form->addError('Bohužel, takový e-mail v databázi již evidujeme.');
        }
    }

    /**
     * Process registration
     *
     * @param Form $form
     */
    public function processForm(Form $form)
    {
        $values = $form->getValues();

        try {
            $user = new User();
            $user->username = $values->username;
            $user->password = Passwords::hash($values->password1);

            // Save user
            $this->repository->persistAndFlush($user);

            // Fire events!
            $this->onRegistration($user, TRUE);
        } catch (\PDOException $e) {
            $this->presenter->flashMessage('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.', 'danger');
        }
    }

    /**
     * Process registration from facebook
     *
     * @param object|GraphObject $me
     */
    public function processFacebook($me)
    {
        $fbid = $me->getProperty('id');
        $email = $me->getProperty('email');

        // Exists user with this FBID?
        $user = $this->repository->getBy(['fbid' => $fbid]);
        if ($user) {
            // Fire events!
            $this->onRegistration($user, FALSE);
            return;
        }

        // Exists user with this USERNAME?
        $user = $this->repository->getBy(['username' => $email]);
        if ($user) {
            try {
                // Update fbid
                $user->fbid = $fbid;

                // Save user
                $this->repository->persistAndFlush($user);

                // Fire events!
                $this->onRegistration($user, FALSE);
            } catch (\PDOException $e) {
                $this->presenter->flashMessage('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.', 'danger');
            }
        } else {
            try {
                $user = new User();
                $user->setRawValue('fbid', $fbid);
                $user->username = $email;
                $user->password = Passwords::hash(time() . $me->getProperty('id'));

                // Save user
                $this->repository->persistAndFlush($user);

                // Fire events!
                $this->onRegistration($user, TRUE);
            } catch (\PDOException $e) {
                $this->presenter->flashMessage('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.', 'danger');
            }
        }
    }

    /**
     * Render login
     */
    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/registration.latte');
        $this->template->render();
    }
}

