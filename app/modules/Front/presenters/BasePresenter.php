<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Common\BasePresenter as CommonBasePresenter;
use App\Common\Controls\Category;
use App\Common\Controls\ICategoryFactory;

/**
 * Base presenter for all front presenters
 */
abstract class BasePresenter extends CommonBasePresenter
{

    /** @var ICategoryFactory */
    protected $categoryFactory;

    /**
     * @param ICategoryFactory $categoryFactory
     */
    function __construct(ICategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @return Category
     */
    protected function createComponentCategory()
    {
        return $this->categoryFactory->create();
    }

}
