<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\BookContact;

use App\Core\Config\EmailConfig;
use App\Core\Controls\BaseControl;
use App\Model\ORM\Entity\Book;
use App\Model\ORM\Entity\Message;
use App\Model\ORM\Repository\BooksRepository;
use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message as Mail;
use Nette\Security\User;

final class BookContact extends BaseControl
{

    /** @var array */
    public $onSent = [];

    /** @var array */
    public $onError = [];

    /** @var BooksRepository */
    private $repository;

    /** @var EmailConfig */
    private $config;

    /** @var IMailer */
    private $mailer;

    /** @var User */
    private $user;

    /** @var Book */
    private $book;

    /**
     * @param BooksRepository $repository
     * @param EmailConfig $config
     * @param IMailer $mailer
     * @param User $user
     */
    public function __construct(
        BooksRepository $repository,
        EmailConfig $config,
        IMailer $mailer,
        User $user,
        Book $book
    )
    {
        parent::__construct();
        $this->repository = $repository;
        $this->config = $config;
        $this->mailer = $mailer;
        $this->user = $user;
        $this->book = $book;
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
        $book = $this->book;

        // Create message
        $message = new Message();

        // Add to book messages
        $book->messages->add($message);
        $this->repository->attach($book);

        $message->message = $values->message;
        $message->user = $this->user->identity->id;
        $message->book = $book;

        // Persist
        $this->repository->persistAndFlush($book);

        // Create mail message
        $mail = new Mail();
        $mail->setFrom($this->config->getFrom());
        $mail->addReplyTo($values->email, $values->name);
        $mail->setReturnPath($this->config->getReturnPath());
        $mail->addBcc($this->config->getBcc());
        $mail->addTo($book->user->username);
        $mail->setSubject('Poptávka: ' . $book->name);

        // Create template
        $template = $this->createTemplate();
        $template->setFile(__DIR__ . '/templates/@mail.latte');
        $template->form = $values;
        $template->book = $book;
        $template->mail = $mail;
        $mail->setHtmlBody($template);

        try {
            // Send message
            $this->mailer->send($mail);
            $this->onSent('Poptávka byla úspěšně odeslána.');
        } catch (\Exception $e) {
            $this->onError('Vaši zprávu se nepodařilo odeslat.');
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
