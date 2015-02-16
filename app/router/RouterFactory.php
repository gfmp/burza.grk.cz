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
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Front:Home:default');
        return $router;
    }

}
