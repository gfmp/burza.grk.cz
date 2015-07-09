<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Manage;

use App\Front\Manage\Forms\BookForm;
use App\Front\Manage\Forms\IBookFormFactory;
use App\Front\Manage\Forms\IImageFormFactory;
use App\Front\Manage\Forms\ImageForm;
use App\Model\Image\ImageManager;
use App\Model\ORM\Entity\Book;
use App\Model\ORM\Entity\Image;
use App\Model\ORM\Repository\BooksRepository;
use App\Model\ORM\Repository\ImagesRepository;
use Nette\Http\FileUpload;
use Nette\Utils\DateTime;

/**
 * Book presenter.
 */
final class BookPresenter extends BasePresenter
{

    /** @var BooksRepository @inject */
    public $booksRepository;

    /** @var ImagesRepository @inject */
    public $imagesRepository;

    /** @var IBookFormFactory @inject */
    public $bookFormFactory;

    /** @var IImageFormFactory @inject */
    public $imageFormFactory;

    /** @var ImageManager @inject */
    public $imageManager;

    /** @var Book */
    private $book;

    /**
     * ADD *********************************************************************
     * *************************************************************************
     */

    /**
     * EDIT ********************************************************************
     * *************************************************************************
     */

    /**
     * @param int $bookId
     */
    public function actionEdit($bookId)
    {
        $this->book = $this->booksRepository->getById($bookId);

        if (!$this->book) {
            $this->flashMessage('Kniha nebyla nalezena.', 'warning');
            $this->redirect('Profile:');
        } else if ($this->book->user->id !== $this->user->identity->id) {
            $this->flashMessage('Nelze upravovat cizí knihu.', 'danger');
            $this->redirect('Profile:');
        }

        $this['bookForm']->setDefaults($this->book->toArray(Book::TO_ARRAY_RELATIONSHIP_AS_ID));
        $this['imageForm']->setDefaults(['book' => $this->book->id]);
    }

    /**
     * @param int $bookId
     */
    public function renderEdit($bookId)
    {
        $this->template->book = $this->book;
    }

    /**
     * HANDLERS ****************************************************************
     * *************************************************************************
     */

    /**
     * @param int $bookId
     */
    public function handleRemoveImage($bookId)
    {
        $book = $this->booksRepository->getById($bookId);
        if ($book) {
            $book->image = NULL;
            $this->booksRepository->persistAndFlush($book);
            $this->flashMessage('Obrázek byl úspěšně smazán.', 'success');
        }

        $this->redirect('this');
    }

    /**
     * BOOK - FORM *************************************************************
     * *************************************************************************
     */

    /**
     * Book form factory.
     *
     * @return BookForm
     */
    protected function createComponentBookForm()
    {
        // Create form
        $form = $this->bookFormFactory->create();

        // Attach handle
        $form->onSuccess[] = callback($this, 'processBookForm');

        return $form;
    }

    /**
     * Process book form.
     *
     * @param BookForm $form
     */
    public function processBookForm(BookForm $form)
    {
        $values = $form->values;

        if ($values->id != NULL) {
            // Edit book
            $book = $this->booksRepository->getById($values->id);
            if (!$book) {
                $this->flashMessage('Chyba při editaci knihy. Prosím zkuste znovu.', 'danger');
                return;
            }
            $book->updatedAt = new DateTime();
        } else {
            // New book
            $book = new Book();
            $book->active = TRUE;
            $book->state = $book::STATE_SELLING;
            $book->createdAt = new DateTime();
        }

        // Attach book
        $this->booksRepository->attach($book);

        // Reguired
        $book->name = $values->name;
        $book->price = $values->price;
        $book->description = $values->description;
        $book->wear = $values->wear;
        $book->category = $values->category;
        $book->user = $this->user->id;

        // Aditional
        $book->author = $values->author;
        $book->publisher = $values->publisher;
        $book->year = is_numeric($values->year) ? $values->year : NULL;

        try {
            // Save/update book
            $this->booksRepository->persistAndFlush($book);

            if ($values->id != NULL) {
                $this->flashMessage('Kniha byla úšpěšně aktualizována.', 'success');
                $this->redirect('this');
                return;
            } else {
                $this->flashMessage('Kniha byla úšpěšně přidána.', 'success');
                $this->redirect('Profile:');
                return;
            }
        } catch (\PDOException $e) {
            $this->flashMessage('Nepovedlo se uložit knihu. Prosím zkuste znovu.', 'danger');
            return;
        }
    }

    /**
     * IMAGE - FORM ************************************************************
     * *************************************************************************
     */

    /**
     * Image form factory.
     *
     * @return ImageForm
     */
    protected function createComponentImageForm()
    {
        // Create form
        $form = $this->imageFormFactory->create();

        // Attach handle
        $form->onSuccess[] = callback($this, 'processImageForm');

        return $form;
    }

    /**
     * Process image form.
     *
     * @param ImageForm $form
     */
    public function processImageForm(ImageForm $form)
    {
        $values = $form->values;

        /** @var FileUpload $file */
        $file = $values->image;

        // Save image
        $filename = $this->imageManager->save($file);
        if ($filename != NULL) {
            $image = new Image();
            $image->filename = $filename;

            // Save image
            $this->imagesRepository->persistAndFlush($image);

            // Attach image to book
            $book = $this->booksRepository->getById($values->book);
            if ($book) {
                $book->image = $image;
                $this->booksRepository->persistAndFlush($book);
            }

            // Display info
            $this->flashMessage('Obrázek byl úspěšně nahrán ke knize.', 'success');
            // Refresh
            $this->redirect('this');
        } else {
            $this->flashMessage('Nepovedlo se nahrát obrázek. Prosím zkuste znovu.', 'warning');
            return;
        }
    }
}
