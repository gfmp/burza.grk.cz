<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Common\BasePresenter as CommonBasePresenter;
use App\Front\Controls\Category\Category;
use App\Front\Controls\Category\ICategoryFactory;
use App\Front\Controls\IssueContact\IIssueContactFactory;
use App\Front\Controls\IssueContact\IssueContact;
use App\Front\Controls\Login\ILoginFactory;
use App\Front\Controls\Login\Login;
use App\Front\Controls\Search\ISearchFactory;
use App\Front\Controls\Search\Search;
use App\Front\Controls\Statistics\IStatisticsFactory;
use App\Front\Controls\Statistics\Statistics;

/**
 * Base presenter for all front presenters
 */
abstract class BasePresenter extends CommonBasePresenter
{

	/** @var ICategoryFactory @inject */
	public $categoryFactory;

	/** @var IIssueContactFactory @inject */
	public $contactFactory;

	/** @var ILoginFactory @inject */
	public $loginFactory;

	/** @var IStatisticsFactory @inject */
	public $statisticsFactory;

	/** @var ISearchFactory @inject */
	public $searchFactory;

	/**
	 * @return Category
	 */
	protected function createComponentCategory()
	{
		return $this->categoryFactory->create();
	}

	/**
	 * @return Login
	 */
	protected function createComponentLogin()
	{
		$login = $this->loginFactory->create();

		$login->onLogin[] = function () {
			// Display info
			$this->flashMessage('Vítejte! Nyní můžete spravovat vaše knihy.', 'success');
			// Redirect
			$this->redirect('this');
		};

		return $login;
	}

	/**
	 * @return IssueContact
	 */
	protected function createComponentContact()
	{
		return $this->contactFactory->create();
	}

	/**
	 * @return Statistics
	 */
	protected function createComponentStatistics()
	{
		return $this->statisticsFactory->create();
	}

	/**
	 * @return Search
	 */
	protected function createComponentSearch()
	{
		$search           = $this->searchFactory->create();
		$search->onSent[] = function ($query) {
			$this->redirect('List:category', [$this->getParameter('categoryId'), $query]);
		};

		return $search;
	}

}
