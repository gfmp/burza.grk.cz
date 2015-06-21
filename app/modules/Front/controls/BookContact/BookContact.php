<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\BooksRepository;
use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

final class BookContact extends BaseControl
{

    /** @var BooksRepository */
    private $repository;

    /** @var IMailer */
    private $mailer;

    /** @var int */
    private $bookId;

    /**
     * @param BooksRepository $usersRepository
     * @param IMailer $mailer
     * @param int $bookId
     */
    public function __construct(BooksRepository $repository, IMailer $mailer, $bookId)
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->bookId = $bookId;
    }

    /**
     * Contact form factory.
     *
     * @return Form
     */
    protected function createComponentForm()
    {
        // Create form
        $form = new Form();

        $form->addText('name', 'Vaše jméno')
            ->setRequired('Vaše jméno je povinné.');

        $form->addText('phone', 'Váš telefon')
            ->addCondition($form::FILLED)
            ->addRule($form::INTEGER, 'Telefon musí být složen jenom z čísel bez předvolby.');

        $form->addText('email', 'Váš e-mail')
            ->setRequired('Vaše e-mail je povinný.')
            ->addRule($form::EMAIL, 'Váš e-mail nemá správný formát.');

        $form->addTextArea('message', 'Vaše zpráva')
            ->setRequired('Vaše zpráva je povinná.')
            ->addRule($form::MIN_LENGTH, 'Minimálně prosím napište %s znaky.', 15);

        $form->addSubmit('send', 'Odeslat poptávku');

        // Attach handle
        $form->onSuccess[] = callback($this, 'processForm');

        return $form;
    }

    /**
     * Process Contact form.
     *
     * @param Form $form
     */
    public function processForm(Form $form)
    {
        $values = $form->values;

        // Fetch book
        $book = $this->repository->getById($this->bookId);
        if (!$book) $this->presenter->error();

        // Create message
        $message = new Message();
        $message->setFrom($values->email, $values->name);
        $message->setReturnPath('info@burza.grk.cz');
        $message->addTo($book->user->username);
        $message->addBcc('rkfelix@gmail.com');
        $message->setSubject('Poptávka: ' . $book->name);

        // Create template
        $template = $this->createTemplate();
        $template->setFile(__DIR__ . '/templates/@mail.latte');
        $template->form = $values;
        $template->book = $book;
        $template->mail = $message;
        $message->setHtmlBody($template);

        try {
            // Send message
            $this->mailer->send($message);
            $this->presenter->flashMessage('Poptávka byla úspěšně odeslána.', 'success');
        } catch (\Exception $e) {
            $this->presenter->flashMessage('Vaši zprávu se nepodařilo odeslat.', 'danger');
        }

        $this->redirect('this');
    }

    /**
     * Render contact
     */
    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/contact.latte');
        $this->template->render();
    }
}
