<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\BookContact\BookContact;
use App\Front\Controls\BookContact\IBookContactFactory;
use App\Model\ORM\Entity\Book;
use App\Model\ORM\Repository\BooksRepository;

/**
 * Book presenter.
 */
final class BookPresenter extends BasePresenter
{

    /** @var IBookContactFactory @inject */
    public $bookContactFactory;

    /** @var BooksRepository @inject */
    public $booksRepository;

    /** @var Book */
    private $book;

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
        $control = $this->bookContactFactory->create($this->book);

        $control->onSent[] = function ($message) {
            $this->flashMessage($message, 'success');
            $this->redirect('this');
        };

        $control->onError[] = function ($message) {
            $this->flashMessage($message, 'danger');
            $this->redirect('this');
        };

        return $control;
    }

}
