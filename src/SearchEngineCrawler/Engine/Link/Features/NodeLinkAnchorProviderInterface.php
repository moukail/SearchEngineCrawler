<?php

/*
 * This file is part of the SearchEngineCrawler package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 * This work is licensed under a [Creative Commons Attribution-NonCommercial 3.0 Unported License](http://creativecommons.org/licenses/by-nc/3.0/).
 */

namespace SearchEngineCrawler\Engine\Link\Features;

interface NodeLinkAnchorProviderInterface
{
    /**
     * Get the link anchor
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeLinkAnchor(\DOMElement $node);
}
