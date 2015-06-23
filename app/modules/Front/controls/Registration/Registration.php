<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Registration;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Entity\User;
use App\Model\ORM\Repository\UsersRepository;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;
use Nette\Security\User as UserSecurity;

/**
 * Registration
 */
final class Registration extends BaseControl
{

    /** @var array */
    public $onRegistration = [];

    /** @var array */
    public $onError = [];

    /** @var UsersRepository */
    private $repository;

    /**
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
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
            $this->onError('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.');
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

