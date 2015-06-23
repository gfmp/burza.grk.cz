<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Routing;

use Nette;
use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Router factory.
 */
class RouterFactory
{

    /**
     * @return IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();

        // Static
        $router[] = new Route('sitemap.xml', 'Front:Generator:sitemap');

        // Front ===============================================================
        $router[] = new Route('category/<categoryId [0-9]+>/', [
            'module' => 'Front',
            'presenter' => 'List',
            'action' => 'category',
        ]);

        $router[] = new Route('book/<bookId [0-9]+>/', [
            'module' => 'Front',
            'presenter' => 'Book',
            'action' => 'detail',
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
