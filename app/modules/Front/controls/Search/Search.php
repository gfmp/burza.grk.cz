<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Search;

use App\Core\Controls\BaseControl;
use Nette\Application\UI\Form;

final class Search extends BaseControl
{

	/** @var array */
	public $onSent = [];

	/** @var array */
	public $onError = [];

	/**
	 * Search form factory.
	 *
	 * @return Form
	 */
	protected function createComponentForm()
	{
		// Create form
		$form = new Form();

		$form->addText('query');

		$form->addSubmit('send', 'Vyhledat');

		// Attach handle
		$form->onSuccess[] = [$this, 'processForm'];

		return $form;
	}

	/**
	 * Process Search form.
	 *
	 * @param Form $form
	 *
	 * @return void
	 */
	public function processForm(Form $form)
	{
		$values = $form->values;

		$this->onSent($values->query);
	}

	/**
	 * Render search
	 *
	 * @return void
	 */
	public function render()
	{
		$this->template->setFile(__DIR__ . '/templates/search.latte');
		$this->template->render();
	}

}
