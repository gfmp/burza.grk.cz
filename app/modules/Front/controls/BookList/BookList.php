<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\BookList;

use App\Core\Controls\BaseControl;
use Nextras\Orm\Collection\ICollection;

final class BookList extends BaseControl
{

    /** @var ICollection */
    private $collection;

    /**
     * @param ICollection $collection
     */
    public function __construct(ICollection $collection)
    {
        parent::__construct();
        $this->collection = $collection;
    }

    /**
     * Render list
     */
    public function render()
    {
        $this->template->books = $this->collection;

        $this->template->setFile(__DIR__ . '/templates/tiles.latte');
        $this->template->render();
    }
}
