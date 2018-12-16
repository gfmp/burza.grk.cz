<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\IssueContact;

use App\Core\Controls\BaseControl;
use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

final class IssueContact extends BaseControl
{

	/** @var array */
	public $onSent = [];

	/** @var array */
	public $onError = [];

	/** @var IMailer */
	private $mailer;

	/**
	 * @param IMailer $mailer
	 */
	public function __construct(IMailer $mailer)
	{
		parent::__construct();
		$this->mailer = $mailer;
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

		$form->addRadioList('type', 'Typ', [0 => 'Nápad', 1 => 'Chyba'])
			->setRequired('Prosím vyberte typ váší zprávy.');

		$form->addText('email', 'Váš e-mail')
			->addCondition($form::FILLED)
			->addRule($form::EMAIL, 'Váš e-mail nemá správný formát.');

		$form->addTextArea('message', 'Vaše zpráva')
			->setRequired('Vaše zpráva je povinná.')
			->addRule($form::MIN_LENGTH, 'Minimálně prosím napište %s znaky.', 15);

		$form->addSubmit('send', 'Odeslat zprávu');

		// Attach handle
		$form->onSuccess[] = [$this, 'processForm'];

		return $form;
	}

	/**
	 * Process Contact form.
	 *
	 * @param Form $form
	 *
	 * @return void
	 */
	public function processForm(Form $form)
	{
		$values = $form->values;

		// Create message
		$message = new Message();
		$message->setFrom($values->email ? $values->email : 'robot@burza.grk.cz');
		$message->addTo('rkfelix@gmail.com');

		if ($values->type == 1) {
			$message->setSubject('Narazil(a) jsem na chybu...');
		} else {
			$message->setSubject('Mám nápad...');
		}

		// Create template
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/templates/@mail.latte');
		$template->form = $values;
		$template->mail = $message;
		$message->setHtmlBody($template);

		try {
			// Send message
			$this->mailer->send($message);
			$this->onSent('Email byl úspěšně odeslán.');
		} catch (\Exception $e) {
			$this->onError('Vaši zprávu se nepodařilo odeslat.');
		}

		$this->redirect('this');
	}

	/**
	 * Render modal
	 *
	 * @return void
	 */
	public function renderModal()
	{
		$this->template->setFile(__DIR__ . '/templates/modal.latte');
		$this->template->render();
	}

}
