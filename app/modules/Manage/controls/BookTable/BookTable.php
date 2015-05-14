<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Manage\Controls;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\BooksRepository;
use Nextras\Orm\Collection\ICollection;

final class BookTable extends BaseControl
{

    /** @var BooksRepository */
    private $repository;

    /** @var ICollection */
    private $collection;

    /**
     * @param BooksRepository $repository
     * @param ICollection $collection
     */
    public function __construct(BooksRepository $repository, ICollection $collection)
    {
        $this->repository = $repository;
        $this->collection = $collection;
    }

    /**
     * @param int $bookId
     */
    public function handleArchive($bookId)
    {
        $book = $this->repository->getById($bookId);
        if ($book) {
            $book->active = FALSE;
            $this->repository->persistAndFlush($book);
            $this->flashMessage('Kniha byla úspěšně deaktivována.', 'success');
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
    public function renderArchive()
    {
        $this->template->books = $this->collection;

        $this->template->setFile(__DIR__ . '/templates/archive.latte');
        $this->template->render();
    }
}
