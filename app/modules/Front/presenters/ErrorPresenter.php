<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use Nette\Application\BadRequestException;
use Tracy\ILogger;

/**
 * Error presenter.
 */
final class ErrorPresenter extends BasePresenter
{

	/** @var ILogger @inject */
	public $logger;

	/**
	 * @param \Exception $exception
	 *
	 * @return void
	 */
	public function renderDefault($exception)
	{
		if ($exception instanceof BadRequestException) {
			$code = $exception->getCode();
			// load template 403.latte or 404.latte or ... 4xx.latte
			$this->setView(in_array($code, [403, 404, 405, 410, 500]) ? $code : '4xx');
			// log to access.log
			$this->logger->log(
				'HTTP code ' . $code . ': ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine(),
				'access'
			);

		} else {
			$this->setView('500'); // load template 500.latte
			$this->logger->log($exception, ILogger::EXCEPTION); // and log exception
		}

		if ($this->isAjax()) { // AJAX request? Note this error in payload.
			$this->payload->error = TRUE;
			$this->terminate();
		}
	}

}
