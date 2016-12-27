<?php

/**
 * Copyright (c) 2011, 2014 WebToad s.r.o. (http://webtoad.cz)
 */

namespace Common\Controls\VisualPaginator;

use Nette\Utils\Paginator;
use WebToad\UI\Control as BaseControl;

/**
 * Visual paginator control.
 *
 * @author    David Grudl
 * @author    Milan Felix Sulc <sulc@webtoad.cz>
 * @copyright WebToad s.r.o. <info@webtoad.cz>
 *
 * @method onChange(Control $vp, int $page)
 */
class Control extends BaseControl
{

	/** @var array */
	public $onChange;

	/** @var int @persistent */
	public $page;

	/** @var Paginator */
	private $paginator;

	/** @var int */
	private $itemsPerPage = 10;

	/**
	 * @return Paginator
	 */
	public function getPaginator()
	{
		if ($this->paginator == NULL) {
			$this->paginator = new Paginator();
			$this->paginator->setItemsPerPage($this->itemsPerPage);
		}

		return $this->paginator;
	}

	/**
	 * @param Paginator $pg
	 *
	 * @return self
	 */
	public function setPaginator(Paginator $pg)
	{
		$this->paginator = $pg;

		return $this;
	}

	/**
	 * @param int $count
	 *
	 * @return self
	 */
	public function setItemsPerPage($count)
	{
		$this->getPaginator()->setItemsPerPage($count);

		return $this;
	}

	/**
	 * @param int $page
	 *
	 * @return void
	 */
	public function handleChange($page)
	{
		$this->onChange($this, $page);
	}

	/**
	 * Renders paginator.
	 *
	 * @return void
	 */
	public function render()
	{
		$paginator = $this->getPaginator();
		$page      = $paginator->page;
		if ($paginator->pageCount < 2) {
			$steps = [$page];
		} else {
			$arr      = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
			$count    = 4;
			$quotient = ($paginator->pageCount - 1) / $count;
			for ($i = 0; $i <= $count; $i++) {
				$arr[] = round($quotient * $i) + $paginator->firstPage;
			}
			sort($arr);
			$steps = array_values(array_unique($arr));
		}

		$this->template->steps     = $steps;
		$this->template->paginator = $paginator;

		// Render paginator
		parent::render();
	}

	/**
	 * Loads state informations.
	 *
	 * @param array $params
	 *
	 * @return void
	 */
	public function loadState(array $params)
	{
		if (empty($params['page'])) {
			$params['page'] = $this->page = 1;
		}
		parent::loadState($params);
		$this->getPaginator()->page = $this->page;
	}

}
