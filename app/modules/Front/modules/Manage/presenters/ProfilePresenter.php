<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage;

use App\Front\Manage\Controls\BookTable\BookTable;
use App\Front\Manage\Controls\BookTable\IBookTableFactory;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\BooksRepository;

/**
 * Profile presenter.
 */
final class ProfilePresenter extends BasePresenter
{

    /** @var IBookTableFactory @inject */
    public $bookTableFactory;

    /** @var BooksRepository @inject */
    public $booksRepository;

    /**
     * Active book table
     *
     * @return BookTable
     */
    protected function createComponentActive()
    {
        return $this->bookTableFactory->create(
            $this->booksRepository
                ->findActive()
                ->findBy(['user' => $this->user->id])
        );
    }

    /**
     * Archive book table
     *
     * @return BookTable
     */
    protected function createComponentArchive()
    {
        return $this->bookTableFactory->create(
            $this->booksRepository
                ->findInactive()
                ->findBy(['user' => $this->user->id])
        );
    }
}
