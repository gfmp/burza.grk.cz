<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Core\Latte;

use Nette\Forms\Form;
use Nette\Utils\Html;

final class FormRuntime
{

	/**
	 * @param Form $form
	 *
	 * @return void
	 */
	public static function renderFormErrors(Form $form)
	{
		if ($form->hasErrors()) {
			$alert = Html::el('div', [
				'class' => 'alert alert-danger alert-dismissible',
				'role'  => 'alert',
			]);

			$button = Html::el('button', [
				'type'         => 'button',
				'class'        => 'close',
				'data-dismiss' => 'alert',
				'aria-label'   => 'Close',
			]);

			$span = Html::el('span', ['aria-hidden' => TRUE])
				->setHtml('&times');

			$alert->add($button->add($span));

			foreach ($form->errors as $error) {
				$el = clone $alert;
				$el->add($error);
				echo $el;
			}
		}
	}

}
