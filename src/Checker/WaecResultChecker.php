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
class WaecResultChecker extends ResultChecker {
        
    public function __construct(Client $client) {
        $requiredFields = [
                            'exam_num' => 'int',
                            'exam_year' => 'int',
                            'exam_type' => 'string',
                            'card_pin' => 'int',
                            'card_serial' => 'string'
                        ];
        
        parent::__construct($client, 'waec', $requiredFields);
    }    

    protected function parseResponse(Crawler $crawler) {
        
    }
    
    protected function getRequestInfo($requestData) {
        $reqData = [
            'ExamNumber' => $requestData['exam_num'],
            'ExamYear' => $requestData['exam_year'],
            'ExamType' => $requestData['exam_type'],
            'serial' => $requestData['card_serial'],
            'pin' => $requestData['card_pin']
        ];
        
        return [
            'url' => 'https://www.waecdirect.org/DisplayResult.aspx',
            'method' => 'GET',
            'params' => $reqData 
        ];
    }
}
