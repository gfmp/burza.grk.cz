<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Statistics;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\BooksRepository;

final class Statistics extends BaseControl
{

    /** @var BooksRepository */
    private $booksRepository;

    /**
     * @param BooksRepository $booksRepository
     */
    public function __construct(BooksRepository $booksRepository)
    {
        parent::__construct();
        $this->booksRepository = $booksRepository;
    }


    /**
     * Render list
     */
    public function renderBooks()
    {
        $this->template->selling = $this->booksRepository->findSelling()->countStored();
        $this->template->sold = $this->booksRepository->findSold()->countStored();

        $this->template->setFile(__DIR__ . '/templates/books.latte');
        $this->template->render();
    }
}
