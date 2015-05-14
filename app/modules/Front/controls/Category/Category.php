<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls;

use App\Core\Controls\BaseControl;
use App\Model\ORM\Repository\CategoriesRepository;

final class Category extends BaseControl
{

    /** @var CategoriesRepository */
    private $repository;

    /**
     * @param CategoriesRepository $repository
     */
    public function __construct(CategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Render list
     */
    public function render()
    {
        $categories = $this->repository->findAll()->orderBy('name', 'ASC');
        $this->template->categories = $categories;

        $this->template->setFile(__DIR__ . '/templates/sidebar.latte');
        $this->template->render();
    }
}
