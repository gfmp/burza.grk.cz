<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Common;

use App\Core\Config\PortalConfig;
use Nette\Application\UI\Presenter;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Presenter
{

    /** @var PortalConfig @inject */
    public $portalConfig;

    /**
     * Common render method.
     */
    protected function beforeRender()
    {
        parent::beforeRender();

        // Paths
        $this->template->storagePath = $this->template->basePath . '/' . $this->portalConfig->expand('paths.storage');
        $this->template->assetsPath = $this->template->basePath . '/assets';
        $this->template->distPath = $this->template->basePath . '/dist';
        $this->template->vendorPath = $this->template->basePath . '/vendor';

        // Deploy
        $this->template->rev = $this->portalConfig->expand('deploy.rev');
        $this->template->debug = $this->portalConfig->expand('debugMode') == TRUE;
    }

    /**
     * COMMON HELPERS **********************************************************
     * *************************************************************************
     */

    /**
     * Gets module name
     *
     * @return string
     */
    public function getModuleName()
    {
        $parts = explode(':', $this->getName());
        return current($parts);
    }

    /**
     * Is current module active?
     *
     * @param string $module Module name
     * @return boolean
     */
    public function isModuleCurrent($module)
    {
        return strpos($this->getAction(TRUE), $module) !== FALSE;
    }

    /**
     * Gets template dir
     *
     * @return string
     */
    public function getTemplateDir()
    {
        return realpath(dirname($this->getReflection()->getFileName()) . '/../templates');
    }
}
