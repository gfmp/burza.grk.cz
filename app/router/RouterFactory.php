<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Routing;

use App\Model\ORM\Service\RouterService;
use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Router factory.
 */
class RouterFactory
{

    /** @var RouterService */
    private $routerService;

    /**
     * @param RouterService $routerService
     */
    function __construct(RouterService $routerService)
    {
        $this->routerService = $routerService;
    }

    /**
     * @return IRouter
     */
    public function create()
    {
        $router = new RouteList();

        // Static
        $router[] = new Route('sitemap.xml', 'Front:Generator:sitemap');

        // Front ===============================================================
        $router[] = new Route('<categoryId .+>/', [
            'module' => 'Front',
            'presenter' => 'List',
            'action' => 'category',
            'categoryId' => [
                Route::FILTER_IN => [$this->routerService, 'categoryIn'],
                Route::FILTER_OUT => [$this->routerService, 'categoryOut'],
            ],
        ]);

        $router[] = new Route('book/<bookId [0-9]+>', 'Front:Book:detail', Route::ONE_WAY);

        $router[] = new Route('kniha/<bookId .+>/', [
            'module' => 'Front',
            'presenter' => 'Book',
            'action' => 'detail',
            'bookId' => [
                Route::FILTER_IN => [$this->routerService, 'bookIn'],
                Route::FILTER_OUT => [$this->routerService, 'bookOut'],
            ],
        ]);

        // Manage ==============================================================
        $router[] = new Route('account/<presenter>/<action>[/<id>]', [
            'module' => 'Front:Manage',
            'presenter' => 'Profile',
            'action' => 'default',
        ]);

        // Default
        $router[] = new Route('<presenter>/<action>[/<id>]', [
            'module' => 'Front',
            'presenter' => 'Home',
            'action' => 'default',
        ]);

        return $router;
    }

}
