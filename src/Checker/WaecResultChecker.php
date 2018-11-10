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

use ResultChecker\Exception\ResultMismatchException;
use ResultChecker\Result\WaecResult;
use ResultChecker\ResultChecker;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise
 */
class WaecResultChecker extends ResultChecker {
    
    const OTHER_ERROR = 'other';
    
    /**
     * 
     * @var Crawler
     */
    private $crawler;
    
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
        $this->crawler = $crawler;
        
        if($this->hasError()) {
            $errorInfo = $this->getErrorInfo();
            return new WaecResult(null, null, $errorInfo);
        }    
        
        $candInfo = $this->getCandidateInfo();
        
        if($candInfo['examNumber'] != $this->requestData['exam_num']) {
            throw new ResultMismatchException('The exam number submitted does not match the exam number received!');
        }
        
        return new WaecResult($candInfo, $this->getResultInfo());
    }
    
    protected function getRequestInfo($requestData) {
        $this->requestData = $requestData;
        
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
    
    private function hasError() {               
        $uriPath = parse_url($this->crawler->getUri(), PHP_URL_PATH);
        if(strpos($uriPath, 'DisplayResult.aspx')) {
            return false;
        }
        
        return true;
    }
    
    private function getErrorInfo() {
        parse_str(parse_url($this->crawler->getUri(), PHP_URL_QUERY), $query);
        
        
        return [
            'type' => self::OTHER_ERROR,
            'title' => $query['errTitle'],
            'message' => $query['errMsg']
        ];
    }
    
    private function getCandidateInfo() {
        $candInfo = [];
        $this->crawler->filter('#tbCandidInfo tbody')
                ->children()
                ->each(function(Crawler $crawler) use (&$candInfo) {
                    $children = $crawler->children();
                    $name = trim($children->first()->text());
                    $value = trim($children->last()->text());
                    
                    switch($name) {
                        case 'Examination Number':
                            $candInfo['examNumber'] = $value;
                            break;
                            
                        case 'Candidate Name':                            
                            $name = explode(' ', $value);
                            $candInfo['lastName'] = trim($name[0]);
                            $candInfo['firstName'] = trim($name[1]);
                            $candInfo['middleName'] = count($name) > 2?  trim($name[2]): '';
                            break;
                        
                        case 'Examination': 
                            $exam = explode(' ', $value);                            
                            $candInfo['period'] = trim($exam[0]);
                            $candInfo['type'] = trim($exam[1]);
                            $candInfo['year'] = trim($exam[2]);
                            break;
                    }
                });        
        
        return $candInfo;
    }
    
    private function getResultInfo() {
        $resultInfo = [];
        $this->crawler->filter('#tbSubjectGrades tbody')
                ->children()
                ->each(function(Crawler $crawler) use (&$resultInfo) {
                    $children = $crawler->children();
                    $name = trim($children->first()->text());
                    $value = trim($children->last()->text());
                    
                    $resultInfo[] = [$name, $value];
                });        
        
        return $resultInfo;
    }
}
