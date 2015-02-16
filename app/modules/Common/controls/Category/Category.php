<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Common\Controls;

use App\Core\Controls\BaseControl;

final class Category extends BaseControl
{

    /**
     * Default view
     */
    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/sidebar.latte');
        $this->template->render();
    }
}