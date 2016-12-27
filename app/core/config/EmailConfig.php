<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Core\Config;

/**
 * Email settings
 */
final class EmailConfig
{

	/** @var array */
	private $parameters;

	/**
	 * @param array $parameters
	 */
	public function __construct(array $parameters)
	{
		$this->parameters = $parameters;
	}

	/**
	 * @return string
	 */
	public function getFrom()
	{
		return $this->parameters['from'];
	}

	/**
	 * @return string
	 */
	public function getReturnPath()
	{
		return $this->parameters['returnPath'];
	}

	/**
	 * @return string
	 */
	public function getTo()
	{
		return $this->parameters['to'];
	}

	/**
	 * @return string
	 */
	public function getBcc()
	{
		return $this->parameters['bcc'];
	}

}
