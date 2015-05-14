<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front;

use App\Common\BasePresenter as CommonBasePresenter;
use App\Front\Controls\Category;
use App\Front\Controls\ICategoryFactory;
use App\Front\Controls\ILoginFactory;
use App\Front\Controls\Login;

/**
 * Base presenter for all front presenters
 */
abstract class BasePresenter extends CommonBasePresenter
{

    /** @var ICategoryFactory @inject */
    public $categoryFactory;

    /** @var ILoginFactory @inject */
    public $loginFactory;

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
}
