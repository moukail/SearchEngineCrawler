<?php

/*
 * This file is part of the SearchEngineCrawler package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 * This work is licensed under a [Creative Commons Attribution-NonCommercial 3.0 Unported License](http://creativecommons.org/licenses/by-nc/3.0/).
 */

namespace SearchEngineCrawlerTest\Crawler;

use SearchEngineCrawler\Crawler\AbstractCrawler;
use SearchEngineCrawler\Crawler\Simple;

class CachedCrawler extends AbstractCrawler
{
    protected $identifier = '';

    protected $autoFileCached = false;

    protected $filePattern;

    public function crawl(array $options = array())
    {
        $filename = sprintf($this->filePattern, strtr($options['builder']['keyword'], ' ', '.'));
        if(!file_exists($filename)) {
            $crawler = new Simple();
            $crawler->setBuilder($this->getBuilder());
            $crawler->crawl($options);
            file_put_contents($filename, $crawler->getSource());
            $this->setSource($crawler->getSource());
            return $this;
        }
        $contents = file_get_contents($filename);

        $this->setSource($contents);
        return $this;
    }

    protected function crawlUri($uri)
    {}

    public function setAutoFileCached($autoFileCached)
    {
        $this->autoFileCached = $autoFileCached;
        return $this;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setFilePattern($filePattern)
    {
        $this->filePattern = $filePattern;
        return $this;
    }
}
