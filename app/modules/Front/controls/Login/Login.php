<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Login;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\UsersRepository;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

/**
 * Login
 */
final class Login extends BaseControl
{

    /** @var array */
    public $onLogin = [];

    /** @var array */
    public $onError = [];

    /** @var UsersRepository */
    private $repository;

    /** @var User */
    private $user;

    /**
     * @param UsersRepository $repository
     * @param User $user
     */
    public function __construct(UsersRepository $repository, User $user)
    {
        parent::__construct();
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

        $form->addPassword('password', 'Heslo')
            ->setRequired('Heslo musí být vyplněno!');

        $form->addCheckbox('remember', 'Zapamatovat')
            ->setDefaultValue(TRUE);

        $form->addSubmit('send', 'Přihlásit se');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    /**
     * Process login
     *
     * @param Form $form
     */
    public function processForm(Form $form)
    {
        $values = $form->getValues();

        // Remember user for long time or only on this session
        if ($values->remember) {
            $this->user->setExpiration('+14 days', FALSE);
        } else {
            $this->user->setExpiration('+20 minutes');
        }

        try {
            // Try sign in
            $this->user->login($values->username, $values->password);

            // Fire event
            $this->onLogin();
        } catch (AuthenticationException $e) {
            $this->onError($e->getMessage());
            return;
        }
    }

    /**
     * Render login
     */
    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/login.latte');
        $this->template->render();
    }

    /**
     * Render navbar
     */
    public function renderNavbar()
    {
        $this->template->setFile(__DIR__ . '/templates/navbar.latte');
        $this->template->render();
    }
}

