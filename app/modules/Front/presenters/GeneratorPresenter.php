<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Front\Controls\Sitemap\ISitemapControlFactory;
use App\Front\Controls\Sitemap\SitemapControl;
use App\Model\ORM\Repository\BooksRepository;
use App\Model\ORM\Repository\CategoriesRepository;

/**
 * GeneratorPresenter
 */
final class GeneratorPresenter extends BasePresenter
{

	/** @var ISitemapControlFactory @inject */
	public $sitemapFactory;

	/** @var BooksRepository @inject */
	public $bookRepository;

	/** @var CategoriesRepository @inject */
	public $categoryRepository;

	/**
	 * @return SitemapControl
	 */
	protected function createComponentSitemap()
	{
		$sitemap = $this->sitemapFactory->create();

		// Find data
		$books      = $this->bookRepository->findAll();
		$categories = $this->categoryRepository->findAll();

		// Add homepage
		$sitemap->addUrl(
			$this->link('//:Front:Home:'),
			$sitemap::FREQ_DAILY,
			1.00
		);

		// Add categories to feed
		foreach ($categories as $category) {
			$sitemap->addUrl(
				$this->link('//:Front:List:category', [$category->id]),
				$sitemap::FREQ_MONTHLY,
				0.7
			);
		}

		// Add posts to feed
		foreach ($books as $book) {
			$sitemap->addUrl(
				$this->link('//:Front:Book:detail', [$book->id]),
				$sitemap::FREQ_WEEKLY,
				0.8
			);
		}

		return $sitemap;
	}

}
