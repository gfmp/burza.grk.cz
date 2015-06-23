<?php

namespace App\Front\Controls\Sitemap;

use Nette\Application\UI\Control;

/**
 * Sitemap Control
 */
class SitemapControl extends Control
{

    /** Change frequency */
    const FREQ_ALWAYS = 'always';
    const FREQ_HOURLY = 'hourly';
    const FREQ_DAILY = 'daily';
    const FREQ_WEEKLY = 'weekly';
    const FREQ_MONTHLY = 'monthly';
    const FREQ_YEARLY = 'yearly';
    const FREQ_NEVER = 'never';

    /** @var array */
    private $urls = [];

    /**
     * @param string $loc
     * @param string $change
     * @param float $priority
     */
    public function addUrl($loc, $change, $priority)
    {
        $this->urls[] = (object)[
            'loc' => $loc,
            'change' => $change,
            'priority' => $priority
        ];
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * RENDERS *****************************************************************
     * *************************************************************************
     */

    /**
     * Render control
     */
    public function render()
    {
        // Render template
        $template = $this->getTemplate();
        $template->setFile(dirname(__FILE__) . "/templates/sitemap.latte");

        $template->urls = $this->urls;

        $template->render();
    }
}
