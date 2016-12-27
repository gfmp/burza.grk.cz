<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Sitemap;

/**
 * Sitemap Control Factory Interface
 */
interface ISitemapControlFactory
{

	/**
	 * @return SitemapControl
	 */
	public function create();

}
