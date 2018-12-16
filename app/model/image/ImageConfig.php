<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Image;

final class ImageConfig
{

	/** @var string */
	private $basePath;

	/** @var string */
	private $wwwDir;

	/** @var string */
	private $storageDir;

	/** @var string */
	private $webtempDir;

	/**
	 * @return string
	 */
	public function getStorageDir()
	{
		return $this->storageDir;
	}

	/**
	 * @param string $storageDir
	 *
	 * @return void
	 */
	public function setStorageDir($storageDir)
	{
		$this->storageDir = $storageDir;
	}

	/**
	 * @return string
	 */
	public function getWwwDir()
	{
		return $this->wwwDir;
	}

	/**
	 * @param string $wwwDir
	 *
	 * @return void
	 */
	public function setWwwDir($wwwDir)
	{
		$this->wwwDir = $wwwDir;
	}

	/**
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->basePath;
	}

	/**
	 * @param string $basePath
	 *
	 * @return void
	 */
	public function setBasePath($basePath)
	{
		$this->basePath = $basePath;
	}

	/**
	 * @return string
	 */
	public function getWebtempDir()
	{
		return $this->webtempDir;
	}

	/**
	 * @param string $webtempDir
	 *
	 * @return void
	 */
	public function setWebtempDir($webtempDir)
	{
		$this->webtempDir = $webtempDir;
	}

	/**
	 * @return string
	 */
	public function getUploadsPath()
	{
		return $this->getBasePath() . '/' . str_replace($this->getWwwDir() . '/', NULL, $this->getStorageDir());
	}

}
