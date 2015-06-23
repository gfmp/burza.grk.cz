<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Forms;

use Nette\Application\UI\Form;

final class ImageForm extends Form
{

    public function __construct()
    {
        $this->addUpload('image', 'Hlavní obrázek')
            ->setRequired('Musíte nejprve vybrat obrázek.')
            ->addRule(self::IMAGE, 'Povolené formáty jsou JPG/PNG/GIF');

        $this->addHidden('book');

        $this->addSubmit('send', 'Nahrát');
    }
}
