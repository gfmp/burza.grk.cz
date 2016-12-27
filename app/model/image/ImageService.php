<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Image;

use App\Model\ORM\Entity\Book;
use App\Model\ORM\Helpers;
use Nette\NotImplementedException;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;

final class ImageService
{

	/** @var ImageConfig */
	private $config;

	/**
	 * @param ImageConfig $config
	 */
	public function __construct(ImageConfig $config)
	{
		$this->config = $config;
	}

	/**
	 * @param string   $image
	 * @param int|NULL $width
	 * @param int|NULL $height
	 * @param int      $method
	 *
	 * @return void //string
	 */
	public function fromString($image, $width, $height, $method)
	{
		throw new NotImplementedException;
	}

	/**
	 * @param Book     $book
	 * @param int|NULL $width
	 * @param int|NULL $height
	 * @param int      $method
	 *
	 * @return string
	 */
	public function fromBookEntity(Book $book, $width, $height, $method)
	{
		if ($book->image == NULL) {
			return $this->config->getBasePath() . '/' . $book->mainImage;
		} else {
			// Generate image unique name
			$filename = $width . 'x' . $height . '/' . $book->image->filename;

			// Absolute path
			$absPath = $this->config->getWebtempDir() . '/' . $filename;

			// Relative path
			$relPath = $this->config->getBasePath() . '/'
				. str_replace($this->config->getWwwDir() . '/', NULL, $this->config->getWebtempDir()) . '/'
				. $filename;

			if (file_exists($absPath)) {
				return $relPath;
			}

			if (!file_exists($this->config->getStorageDir() . DIRECTORY_SEPARATOR . $book->image->filename)) {
				$image = Image::fromFile($this->config->getWwwDir() . DIRECTORY_SEPARATOR . Helpers::getPlaceholdImage($book->id));
			} else {
				// Create image obj
				$image = Image::fromFile($this->config->getStorageDir() . DIRECTORY_SEPARATOR . $book->image->filename);

				if ($image->width > $image->height) {
					$image = $image->rotate(-90, Image::rgb(0, 0, 0));
				}
			}

			// Resize
			$image->resize($width, $height, $method);

			// Create dir
			FileSystem::createDir(dirname($absPath));

			// Save image
			$image->save($absPath, 80);

			return $relPath;
		}
	}

	/**
	 * @param Image    $image
	 * @param int|NULL $width
	 * @param int|NULL $height
	 * @param int      $method
	 *
	 * @return void //string
	 */
	public function fromImageEntity(Image $image, $width, $height, $method)
	{
		throw new NotImplementedException;
	}

}
