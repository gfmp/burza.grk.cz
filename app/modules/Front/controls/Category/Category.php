<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Category;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\BooksRepository;
use App\Model\ORM\Repository\CategoriesRepository;

final class Category extends BaseControl
{

	/** @var CategoriesRepository */
	private $categoriesRepository;

	/**
	 * @var BooksRepository
	 */
	private $booksRepository;

	/**
	 * @param CategoriesRepository $repository
	 * @param BooksRepository      $booksRepository
	 */
	public function __construct(CategoriesRepository $repository, BooksRepository $booksRepository)
	{
		parent::__construct();
		$this->categoriesRepository = $repository;
		$this->booksRepository      = $booksRepository;
	}

	/**
	 * Render list
	 *
	 * @return void
	 */
	public function render()
	{
		$categories      = $this->categoriesRepository->findAll()->orderBy('name', 'ASC');
		$categoriesCount = $this->booksRepository->countSellingByCategories($categories);

		$this->template->categories      = $categories;
		$this->template->categoriesCount = $categoriesCount;

		$this->template->setFile(__DIR__ . '/templates/sidebar.latte');
		$this->template->render();
	}

}
