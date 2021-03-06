<?php

/*
 * This file is part of the SearchEngineCrawler package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 * This work is licensed under a [Creative Commons Attribution-NonCommercial 3.0 Unported License](http://creativecommons.org/licenses/by-nc/3.0/).
 */

namespace SearchEngineCrawlerTest\Engine\Google\Match;

use SearchEngineCrawler\Engine\Google\Video as GoogleVideo;
use SearchEngineCrawler\Engine\Link\Builder\Google\AbstractGoogle as GoogleLinkBuilder;
use SearchEngineCrawler\Result\Match;
use SearchEngineCrawlerTest\Engine\AbstractTest;

class VideoTest extends AbstractTest
{
    protected $links = array('video', 'natural');

    public function setUp()
    {
        $this->cachePattern = __DIR__ . '/../sources/video/%s.html';
        $this->engine = new GoogleVideo();
        parent::setUp();
    }

    public function test_Bieber_Case()
    {
        $this->keywordRegister('bieber');

        $crawlerMatch = $this->engine->getCrawlerMatch();
        $crawlerMatch->setOptions(array(
            'strictMode' => false,
            'strictDns' => false,
        ));
        $match = $this->engine->match($this->keyword, 'http://www.gentside.com/', array(
            'links' => $this->links,
            'builder' => array(
                'lang' => GoogleLinkBuilder::LANG_FR,
                'host' => GoogleLinkBuilder::HOST_FR,
            ),
        ));
        $this->assertTrue($match instanceof Match);
        $this->assertEquals($match->getPosition(), 5);
        $this->assertEquals($match->getPage(), 1);
    }
}
