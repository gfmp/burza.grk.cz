<?php

/**
 * Copyright (c) 2011, 2014 WebToad s.r.o. (http://webtoad.cz)
 */

namespace Common\Controls\VisualPaginator;

/**
 * Visual Paginator Control Factory Interface
 *
 * @author Milan Felix Sulc <sulc@webtoad.cz>
 * @copyright WebToad s.r.o. <info@webtoad.cz>
 */
interface IControlFactory
{

    /**
     * @return Control
     */
    function create();
}