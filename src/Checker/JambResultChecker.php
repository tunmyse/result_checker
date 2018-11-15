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

use DateTime;
use ResultChecker\Exception\ResultMismatchException;
use ResultChecker\Exception\ResultProcessingException;
use ResultChecker\ResultChecker;
use ResultChecker\Result\JambResult;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise
 */
class JambResultChecker extends ResultChecker {    
    
    const NO_RESULT_FOUND = 'no_result_found';
    
    /**
     * 
     * @var Crawler
     */
    private $crawler;
    
    public function __construct(Client $client) {
        $requiredFields = [
                            'cand_num' => 'string'
                        ];
        
        parent::__construct($client, 'jamb', $requiredFields);
    }    

    protected function parseResponse(Crawler $crawler) {
        $this->crawler = $crawler;
        
        if($this->hasError()) {
            $errorInfo = $this->getErrorInfo();
            throw new ResultProcessingException($errorInfo);
        }    
        
        $candInfo = $this->getCandidateInfo();
        
        if($candInfo['candidateNumber'] != $this->requestData['cand_num']) {
            throw new ResultMismatchException('The exam number submitted does not match the exam number in the result!');
        }
        
        return new JambResult($candInfo, $this->getResultInfo());
    }

    protected function getRequestInfo($requestData) {
        
        $this->requestData = $requestData;
        
        $reqData = [
            'txtRegNumber' => $requestData['cand_num'],
            '__EVENTTARGET' => 'lnkSearch',
            '__EVENTVALIDATION' => 'rrGpGfQKamSxBpEXBnMZJkJh9Zz6bDKvGimAnGiIpdGOwdTlKnPunnPmIj3Mk514GsSXn5O4Q2uxWQRm5M32cdY0fD0PyEqrO3O6LxJtVM3Yt9nw2JUJlvgpvMGyTCVAfAvQVRHSYl8/wgLZlbBQ+g==',
            '__VIEWSTATE' => 'lx9X2GcpMiRUuxBQz9CJoPXzhMd5A8JrtmuiXPooieWQl4bLgFET4LkL4HCMky6q7lnc4Z/7Z69NsCdbWqZsuOagvjxGvM5Ew3lLP0enR6UBBT+ohkvcWWUxyvAxz8WyU1EXMDIXPZ51qKvwF3Gg6WbkGhIs3tHpkMDpYRUz36wwIXGBTijnswTU2D9tJqDl'
        ];
        
        return [
            'url' => 'https://www.jamb.org.ng/ExamSlipPrinting3/CheckUTMEResults',
            'method' => 'POST',
            'params' => $reqData 
        ];
    }
    
    private function hasError() {
        return $this->crawler->filter('#dvResults')->count() === 0? true: false;
    }

    private function getErrorInfo() {
        return [
            'type' => self::NO_RESULT_FOUND,
            'title' => 'No result found',
            'message' => 'The candidate may not have a result in the most recent exam year or the candidate number is invalid!'
        ];
    }

    private function getCandidateInfo() {
        $candInfo = [];
        $this->crawler->filter('#dvAll table')
                ->eq(1)
                ->children()
                ->each(function(Crawler $crawler, $pos) use (&$candInfo) {
                    if($pos == 6)
                        return;
                    
                    $children = $crawler->children();
                    $name = str_replace(':', '', trim($children->first()->text()));
                    $value = trim($children->last()->text());

                    switch ($name) {
                        case 'Name':
                            $name = explode(' ', $value);
                            $candInfo['lastName'] = trim($name[0]);
                            $candInfo['firstName'] = trim($name[1]);
                            $candInfo['middleName'] = count($name) > 2 ? trim($name[2]) : '';
                            break;

                        case 'Reg Number':                            
                            $candInfo['candidateNumber'] = $value;
                            break;

                        case 'Date of Birth':
                            $candInfo['dob'] = $value;
                            
                            $dob = new DateTime($value);
                            $candInfo['age'] = $dob->diff(new DateTime('now'))->format('%y');
                            break;
                        
                        case 'Origin':
                            $exam = explode(' ', $value);
                            $candInfo['lga'] = trim($exam[0]);
                            $candInfo['state'] = trim($exam[2]);
                            break;
                        
                        case 'Exam No':
                            $candInfo['examNumber'] = $value;
                            break;                    
                    }
                });

        return $candInfo;
    }

    private function getResultInfo() {
        $resultInfo = [];
        $total = 0;
        
        $this->crawler->filter('#gdvTransHistory > tr')
                ->each(function(Crawler $crawler , $pos) use (&$resultInfo, &$total) {
                    if($pos == 0 )
                        return;
                    
                    $children = $crawler->children();
                    $name = trim($children->first()->text());
                    $value = intval(trim($children->last()->text()));

                    $total += $value;
                    $resultInfo['result'][] = ['subject' => $name, 'score' => $value];
                });

        $resultInfo['total'] = $total;
        return $resultInfo;
    }
}
