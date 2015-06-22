<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\BookContact;
use App\Front\Controls\IBookContactFactory;
use App\Front\Controls\IContactFactory;
use App\Model\ORM\Entity\Book;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\BooksRepository;

/**
 * Book presenter.
 */
final class BookPresenter extends BasePresenter
{

    /** @var IBookContactFactory @inject */
    public $bookContactFactory;

    /** @var BooksRepository */
    public $booksRepository;

    /** @var Book */
    private $book;

    /**
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->booksRepository = $orm->books;
    }

    /**
     * DETAIL ******************************************************************
     * *************************************************************************
     */

    /**
     * @param int $bookId
     */
    public function actionDetail($bookId)
    {
        $this->book = $this->booksRepository->getById($bookId);

        if (!$this->book) {
            $this->flashMessage('Kniha nebyla nalezena.', 'warning');
            $this->redirect('Home:');
        }
    }

    /**
     * @param int $bookId
     */
    public function renderDetail($bookId)
    {
        $this->template->book = $this->book;
    }


    /**
     * CONTACT *****************************************************************
     * *************************************************************************
     */

    /**
     * BookContact factory.
     *
     * @return BookContact
     */
    protected function createComponentBookContact()
    {
        return $this->bookContactFactory->create($this->book->id);
    }

}
