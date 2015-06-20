<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\BookList;
use App\Front\Controls\IBookListFactory;
use App\Model\ORM\Orm;
use App\Model\ORM\Repository\BooksRepository;
use Nextras\Orm\Collection\ICollection;

/**
 * List presenter.
 */
final class ListPresenter extends BasePresenter
{

    /** @var IBookListFactory @inject */
    public $bookListFactory;

    /** @var BooksRepository */
    private $booksReposity;

    /** @var ICollection */
    private $booksCollection;

    /**
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->booksReposity = $orm->books;
    }

    /**
     * DEFAULT *****************************************************************
     * *************************************************************************
     */
    public function actionDefault()
    {
        $this->booksCollection = $this->booksReposity
            ->findActive()
            ->orderBy('id', 'DESC');

        $this->template->books = $this->booksCollection;
    }

    /**
     * CATEGORY ****************************************************************
     * *************************************************************************
     */

    /**
     * @param int $categoryId
     */
    public function actionCategory($categoryId)
    {
        $this->booksCollection = $this->booksReposity
            ->findActive()
            ->findBy(['category' => $categoryId])
            ->orderBy('id', 'DESC');

        $this->template->books = $this->booksCollection;
    }

    /**
     * BOOK LIST ***************************************************************
     * *************************************************************************
     */

    /**
     * BookList control factory.
     *
     * @return BookList
     */
    protected function createComponentBookList()
    {
        // Create control
        $control = $this->bookListFactory->create($this->booksCollection);

        return $control;
    }
}
