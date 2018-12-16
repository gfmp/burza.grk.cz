<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

/**
 * Home presenter.
 */
final class HomePresenter extends BasePresenter
{

	/**
	 * Forward request
	 *
	 * @return void
	 */
	public function actionDefault()
	{
		$this->forward('List:default');
	}

}
