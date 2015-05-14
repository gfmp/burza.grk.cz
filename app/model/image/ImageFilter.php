<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Image;

use App\Model\ORM\Entity\Book;
use App\Model\ORM\Entity\Image;
use Nette\Utils\Image as NImage;

final class ImageFilter
{

    /** @var ImageService */
    private $service;

    /**
     * @param ImageService $service
     */
    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $s
     * @param int|NULL $width
     * @param int|NULL $height
     * @param int $method
     * @return string
     */
    public function string($s, $width = NULL, $height = NULL, $method = NImage::SHRINK_ONLY)
    {
        return $this->service->fromString($s, $width, $height, $method);
    }

    /**
     * @param Book $e
     * @param int|NULL $width
     * @param int|NULL $height
     * @param int $method
     * @return string
     */
    public function book($e, $width = NULL, $height = NULL, $method = NImage::SHRINK_ONLY)
    {
        return $this->service->fromBookEntity($e, $width, $height, $method);
    }

    /**
     * @param Image $e
     * @param int|NULL $width
     * @param int|NULL $height
     * @param int $method
     * @return string
     */
    public function image($e, $width = NULL, $height = NULL, $method = NImage::SHRINK_ONLY)
    {
        return $this->service->fromImageEntity($e,$width, $height, $method);
    }
}