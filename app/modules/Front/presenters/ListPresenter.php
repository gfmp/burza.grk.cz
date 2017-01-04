<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\BookList\BookList;
use App\Front\Controls\BookList\IBookListFactory;
use App\Model\ORM\Repository\BooksRepository;
use Nextras\Orm\Collection\ICollection;

/**
 * List presenter.
 */
final class ListPresenter extends BasePresenter
{

	/** @var IBookListFactory @inject */
	public $bookListFactory;

	/** @var BooksRepository @inject */
	public $booksRepository;

	/** @var ICollection */
	private $booksCollection;

	/**
	 * DEFAULT *****************************************************************
	 * *************************************************************************
	 *
	 * @return void
	 */
	public function actionDefault()
	{
		$this->booksCollection = $this->booksRepository
			->findSelling()
			->orderBy('id', 'DESC')
			->limitBy(12);

		$this->template->books = $this->booksCollection;
	}

	/**
	 * CATEGORY ****************************************************************
	 * *************************************************************************
	 */

	/**
	 * @param int    $categoryId
	 * @param string $query
	 *
	 * @return void
	 */
	public function actionCategory($categoryId, $query)
	{
		$collection = $this->booksRepository
			->findSellingByName($query)
			->orderBy('id', 'DESC');

		if ($categoryId) {
			$collection = $collection->findBy(['category' => $categoryId]);
		}

		$this->booksCollection = $collection;

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
