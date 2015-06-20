<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Image;

use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;

final class ImageManager
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
     * @param FileUpload $file
     * @return string|NULL
     */
    public function save(FileUpload $file)
    {
        if (!$file->isImage() || !$file->isOk()) {
            return NULL;
        }

        // Generate image unique name
        $filename = md5($file->getName() . time());
        $ext = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
        $filename = sprintf('%s/%s.%s', date('Y/m/d'), $filename, $ext);

        // Create folder
        FileSystem::createDir($this->config->getStorageDir() . DIRECTORY_SEPARATOR . dirname($filename));

        // Move image to folder
        $file->move($this->config->getStorageDir() . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    /**
     * @param string $file
     */
    public function remove($file)
    {
        @unlink($this->config->getStorageDir() . DIRECTORY_SEPARATOR . $file);
    }

}
