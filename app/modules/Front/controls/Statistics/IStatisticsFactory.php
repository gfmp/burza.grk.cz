<?php

/**
 * @package burza.grk.cz
 * @author  Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Front\Controls\Statistics;

interface IStatisticsFactory
{

	/**
	 * @return Statistics
	 */
	public function create();

}
