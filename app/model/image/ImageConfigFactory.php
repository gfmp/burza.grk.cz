<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Image;

use Nette\Http\Request;

final class ImageConfigFactory
{

	/** @var Request */
	private $httpRequest;

	/** @var string */
	private $wwwDir;

	/** @var string */
	private $storageDir;

	/** @var string */
	private $webtempDir;

	/**
	 * ImageConfigFactory constructor.
	 *
	 * @param Request $httpRequest
	 * @param string  $wwwDir
	 * @param string  $storageDir
	 * @param string  $webtempDir
	 */
	public function __construct(Request $httpRequest, $wwwDir, $storageDir, $webtempDir)
	{
		$this->httpRequest = $httpRequest;
		$this->wwwDir      = rtrim($wwwDir);
		$this->storageDir  = rtrim($storageDir, '/');
		$this->webtempDir  = rtrim($webtempDir, '/');
	}

	/**
	 * @return ImageConfig
	 */
	public function create()
	{
		$config = new ImageConfig();

		$baseUrl  = rtrim($this->httpRequest->getUrl()->getBaseUrl(), '/');
		$basePath = preg_replace('#https?://[^/]+#A', '', $baseUrl);
		$config->setBasePath($basePath);

		$config->setStorageDir($this->storageDir);
		$config->setWwwDir($this->wwwDir);
		$config->setWebtempDir($this->webtempDir);

		return $config;
	}

}
