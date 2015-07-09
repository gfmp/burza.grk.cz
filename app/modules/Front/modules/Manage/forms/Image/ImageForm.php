<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Forms;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\UploadControl;
use Nette\Utils\Image;

final class ImageForm extends Form
{

    public function __construct()
    {
        $this->addUpload('image', 'Hlavní obrázek')
            ->setRequired('Musíte nejprve vybrat obrázek.')
            ->addRule(self::IMAGE, 'Povolené formáty jsou JPG/PNG/GIF')
            ->addRule([$this, 'validateImageSize'], 'Nahrávejte prosím obrázek na výšku.');

        $this->addHidden('book');

        $this->addSubmit('send', 'Nahrát');
    }

    /**
     * @param UploadControl $control
     * @return bool
     */
    public function validateImageSize(UploadControl $control)
    {
        /** @var Image $image */
        $image = $control->getValue()->toImage();

        if ($image->width > $image->height) {
            return FALSE;
        }

        return TRUE;
    }
}
