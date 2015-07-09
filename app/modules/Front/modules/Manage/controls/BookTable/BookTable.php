<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage\Controls\BookTable;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Entity\Book;
use App\Model\ORM\Repository\BooksRepository;
use Nette\Application\ForbiddenRequestException;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Security\User;
use Nextras\Orm\Collection\ICollection;

final class BookTable extends BaseControl
{

    /** @var BooksRepository */
    private $repository;

    /** @var ICollection */
    private $collection;

    /** @var User */
    private $user;

    /**
     * @param BooksRepository $repository
     * @param ICollection $collection
     * @param User $user
     */
    public function __construct(BooksRepository $repository, ICollection $collection, User $user)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->collection = $collection;
        $this->user = $user;
    }

    /**
     * @param int $bookId
     */
    public function handleArchive($bookId)
    {
        $book = $this->getBook($bookId);
        if ($book) {
            $book->state = Book::STATE_ARCHIVED;
            $this->repository->persistAndFlush($book);
            $this->flashMessage('Kniha byla úspěšně archivována.', 'success');
        }

        $this->redirect('this');
    }

    /**
     * @param int $bookId
     */
    public function handleSold($bookId)
    {
        $book = $this->getBook($bookId);
        if ($book) {
            $book->state = Book::STATE_SOLD;
            $this->repository->persistAndFlush($book);
            $this->flashMessage('Kniha byla úspěšně označena jako prodána.', 'success');
        }

        $this->redirect('this');
    }


    /**
     * @param int $bookId
     */
    public function handleActive($bookId)
    {
        $book = $this->getBook($bookId);
        if ($book) {
            $book->state = Book::STATE_SELLING;
            $this->repository->persistAndFlush($book);
            $this->flashMessage('Kniha byla úspěšně aktivována.', 'success');
        }

        $this->redirect('this');
    }

    /**
     * Render list
     */
    public function renderActive()
    {
        $this->template->books = $this->collection;

        $this->template->setFile(__DIR__ . '/templates/active.latte');
        $this->template->render();
    }

    /**
     * Render list
     */
    public function renderOther()
    {
        $this->template->books = $this->collection;

        $this->template->setFile(__DIR__ . '/templates/other.latte');
        $this->template->render();
    }

    /**
     * @param int $bookId
     * @return Book
     */
    private function getBook($bookId)
    {
        /** @var Book $book */
        $book = $this->repository->getById($bookId);

        if (!$book) {
            throw new InvalidArgumentException('Uknown book ID.');
        }

        if ($book->user->id !== $this->user->identity->id) {
            throw new ForbiddenRequestException('Cannot manipulate with foreign book.');
        }

        return $book;
    }
}
