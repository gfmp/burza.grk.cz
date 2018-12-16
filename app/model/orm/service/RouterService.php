<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\ORM\Service;

use App\Model\ORM\Repository\BooksRepository;
use App\Model\ORM\Repository\CategoriesRepository;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Utils\Strings;

final class RouterService
{

	/** @var BooksRepository */
	private $booksRepository;

	/** @var CategoriesRepository */
	private $categoryRepository;

	/** @var Cache */
	private $cache;

	/**
	 * @param BooksRepository      $booksRepository
	 * @param CategoriesRepository $categoryRepository
	 * @param IStorage             $cacheStorage
	 */
	public function __construct(
		BooksRepository $booksRepository,
		CategoriesRepository $categoryRepository,
		IStorage $cacheStorage
	)
	{
		$this->booksRepository    = $booksRepository;
		$this->categoryRepository = $categoryRepository;
		$this->cache              = new Cache($cacheStorage, 'Burza.Router');

		// Build caches
		$this->categoryBuildCache();
		$this->bookBuildCache();
	}

	/**
	 * CATEGORY ****************************************************************
	 */

	/**
	 * @return void
	 */
	protected function categoryBuildCache()
	{
		$cache = $this->categoryRepository->findAll()->fetchPairs('id', 'slug');
		$this->cache->save('category', $cache, [Cache::TAGS => ['router', 'category'], Cache::EXPIRE => '+ 1 day']);
	}

	/**
	 * @param string $slug
	 *
	 * @return int
	 */
	public function categoryIn($slug)
	{
		$cache    = $this->cache->load('category');
		$category = array_search($slug, $cache);

		return $category ? $category : NULL;
	}

	/**
	 * @param int $id
	 *
	 * @return string|NULL
	 */
	public function categoryOut($id)
	{
		$id    = intval($id);
		$cache = $this->cache->load('category');

		return isset($cache[$id]) ? $cache[$id] : NULL;
	}

	/**
	 * BOOK ********************************************************************
	 */

	/**
	 * @return void
	 */
	protected function bookBuildCache()
	{
		$cache = $this->booksRepository->findAll()->fetchPairs('id', 'slug');
		$this->cache->save('book', $cache, [Cache::TAGS => ['router', 'book'], Cache::EXPIRE => '+ 1 hour']);
	}

	/**
	 * @param string $slug
	 *
	 * @return int
	 */
	public function bookIn($slug)
	{
		list($whole, $id, $slug) = Strings::match($slug, '#([0-9]+)\-(.*)#');

		return $id;
	}

	/**
	 * @param int $id
	 *
	 * @return string|NULL
	 */
	public function bookOut($id)
	{
		$id    = intval($id);
		$cache = $this->cache->load('book');

		return isset($cache[$id]) ? $id . '-' . $cache[$id] : $id . '-' . time();
	}

}
