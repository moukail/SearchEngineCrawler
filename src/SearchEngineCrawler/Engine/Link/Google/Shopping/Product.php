<?php

/*
 * This file is part of the SearchEngineCrawler package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 * This work is licensed under a [Creative Commons Attribution-NonCommercial 3.0 Unported License](http://creativecommons.org/licenses/by-nc/3.0/).
 */

namespace SearchEngineCrawler\Engine\Link\Google\Shopping;

use SearchEngineCrawler\Engine\Link\AbstractLink;
use SearchEngineCrawler\Engine\Link\Features;

class Product extends AbstractLink implements Features\NodeLinkAnchorProviderInterface,
    Features\NodeImageSourceProviderInterface, Features\NodePriceProviderInterface
{
    /**
     * Result class container
     * @var string
     */
    protected $resultClass = 'SearchEngineCrawler\ResultSet\Link\Result\Product';

    /**
     * Get the node list, each node contains
     * the ad & line number
     * @return Zend\Dom\NodeList
     */
    public function getNodeList()
    {
        return $this->xpath('//ol[@id="rso"]/li[contains(@class,"g psgi")]');
    }

    /**
     * Check if a node is valid, if the node match with the type required
     * If node is valid, return the node
     * @param \DOMElement $node node to validate
     * @return null|\DOMElement
     */
    public function validateNode(\DOMElement $node)
    {
        $nodePath = $node->getNodePath();
        $nodePath .= '//span[@class="psrp"]';
        return $this->xpath($nodePath)->current();
    }

    /**
     * Get the link
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeLink(\DOMElement $node)
    {
        $nodePath = $node->getNodePath();
        $nodePath .= '//div[@class="psgicont"]/h3[@class="psrt"]/a';
        $link = $this->xpath($nodePath)->current();
        $href = $link->getAttribute('href');
        if(preg_match('#adurl=(?P<domain>.*)$#', $href, $regs)) {
			$href = $regs['domain'];
		} else if(preg_match('#^/#', $href)) {
			$href = 'http://www.google.com' . $href;
		}
        return $href;
    }

    /**
     * Get the link anchor
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeLinkAnchor(\DOMElement $node)
    {
        $nodePath = $node->getNodePath();
		$nodePath .= '//div[@class="psgicont"]/h3[@class="psrt"]/a';
        $link = $this->xpath($nodePath)->current();
        return $link->textContent;
    }

    /**
     * Get the link anchor
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeImageSource(\DOMElement $node)
    {
        $nodePath = $node->getNodePath();
        $nodePath .= '//a[@class="psgiimg"]/img';
        $img = $this->xpath($nodePath)->current();
        return $img->getAttribute('src');
    }

    /**
     * Get price from product
     * @param \DOMElement $node
     * @return string a price
     */
    public function getNodePrice(\DOMElement $node)
    {
        $price = $this->validateNode($node);
        return $price->textContent;
    }
}
