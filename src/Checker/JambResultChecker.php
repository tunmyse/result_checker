<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Checker;

use ResultChecker\ResultChecker;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise
 */
class JambResultChecker extends ResultChecker {
    
    public function __construct(Client $client) {
        parent::__construct($client, 'jamb', []);
    }    

    protected function parseResponse(Crawler $crawler) {
        
    }

    protected function getRequestInfo($requestData) {
        
    }

}
