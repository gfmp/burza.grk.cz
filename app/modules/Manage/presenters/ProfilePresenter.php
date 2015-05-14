<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage;

use App\Manage\Controls\BookTable;
use App\Manage\Controls\IBookTableFactory;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\BooksRepository;

/**
 * Profile presenter.
 */
final class ProfilePresenter extends BasePresenter
{

    /** @var IBookTableFactory @inject */
    public $bookTableFactory;

    /** @var BooksRepository */
    public $booksRepository;

    /**
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->booksRepository = $orm->books;
    }

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
