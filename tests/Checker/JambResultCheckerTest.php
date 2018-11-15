<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Tests\Checker;

use PHPUnit\Framework\TestCase;
use ResultChecker\Checker\JambResultChecker;
use ResultChecker\Exception\ResultMismatchException;
use ResultChecker\Exception\ResultProcessingException;
use ResultChecker\Result\JambResult;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of WaecResultCheckerTest
 *
 * @author Oluwatunmise Akinsola
 */
class JambResultCheckerTest extends TestCase {
    
    private $client;
    
    private $checker;
    
    private $validData;
    
    /**
     * Set up function
     */
    public function setUp() {
        
        $this->client = $this->getMockForAbstractClass(Client::class, [], '', true, true, true, ['request']); 
        $this->validData = [
                    'cand_num' => '85982172FF'
                ];
        
        $this->checker = $this->getMockBuilder(JambResultChecker::class)
                                ->enableOriginalConstructor()
                                ->setMethods(null)  
                                ->setConstructorArgs([$this->client])
                                ->getMock();
    }
    
    /**
     * @test
     */
    public function returnsRequestInfo() {
        $reqData = [
            'txtRegNumber' => $this->validData['cand_num'],
            '__EVENTTARGET' => 'lnkSearch',
            '__EVENTVALIDATION' => 'rrGpGfQKamSxBpEXBnMZJkJh9Zz6bDKvGimAnGiIpdGOwdTlKnPunnPmIj3Mk514GsSXn5O4Q2uxWQRm5M32cdY0fD0PyEqrO3O6LxJtVM3Yt9nw2JUJlvgpvMGyTCVAfAvQVRHSYl8/wgLZlbBQ+g==',
            '__VIEWSTATE' => 'lx9X2GcpMiRUuxBQz9CJoPXzhMd5A8JrtmuiXPooieWQl4bLgFET4LkL4HCMky6q7lnc4Z/7Z69NsCdbWqZsuOagvjxGvM5Ew3lLP0enR6UBBT+ohkvcWWUxyvAxz8WyU1EXMDIXPZ51qKvwF3Gg6WbkGhIs3tHpkMDpYRUz36wwIXGBTijnswTU2D9tJqDl'
        ];
        
        $crawler = $this->createPartialMock(Crawler::class, ['count', 'filter']);
        $crawler
                ->expects($this->once())
                ->method('count')              
                ->willReturn(0);
        
        $crawler
                ->expects($this->once())
                ->method('filter')              
                ->willReturn($crawler);
        
        $this->client
                ->expects($this->once())
                ->method('request')
                ->with('POST', 'https://www.jamb.org.ng/ExamSlipPrinting3/CheckUTMEResults', $reqData)                
                ->willReturn($crawler);
        
        $this->expectException(ResultProcessingException::class);
        $this->checker->getResult($this->validData);                
    }
    
    /**
     * @test
     */
    public function checkResponseForError() {    
        $crawler = $this->createPartialMock(Crawler::class, ['filter', 'count']);
        $crawler
                ->expects($this->once())
                ->method('filter') 
                ->with('#dvResults')              
                ->willReturn($crawler);
        
        $crawler
                ->expects($this->once())
                ->method('count')              
                ->willReturn(0);
        
        $this->client
                ->expects($this->once())
                ->method('request')               
                ->willReturn($crawler);
        
        try {
            $this->checker->getResult($this->validData); 
            $this->fail();
        }catch (ResultProcessingException $ex) {
            $this->assertSame(JambResultChecker::NO_RESULT_FOUND, $ex->getType());
        }
    }
    
    /**
     * @test
     */
    public function checksResultIsForCandidate() {  
        require 'jamb_resp.php';
        $crawler = new Crawler($jambText, 'https://www.jamb.org.ng/ExamSlipPrinting3/CheckUTMEResults');
        $this->validData['cand_num'] = '86179306GC';
        
        $this->client
                ->expects($this->once())
                ->method('request')               
                ->willReturn($crawler);
        
        $this->expectException(ResultMismatchException::class);
        $this->checker->getResult($this->validData);  
    }
    
    /**
     * @test
     */
    public function returnsValidResultType() {       
        require 'jamb_resp.php';
        $realCrawler = new Crawler($jambText, 'https://www.waecdirect.org/DisplayResult.aspx');
                
        $crawler = $this->createPartialMock(Crawler::class, ['filter']);
        
        $this->client
                ->method('request')               
                ->willReturn($crawler);
        
        $crawler->expects($this->exactly(3))
                ->method('filter')
                ->withConsecutive(['#dvResults'], ['#dvAll table'], ['#gdvTransHistory > tr'])
                ->willReturnOnConsecutiveCalls($realCrawler->filter('#dvResults'), $realCrawler->filter('#dvAll table'), $realCrawler->filter('#gdvTransHistory > tr'));
                
        $result = $this->checker->getResult($this->validData);       
        $this->assertInstanceOf(JambResult::class, $result);
        
        return $result;
    }    
    
    /**
     * @test
     * @depends clone returnsValidResultType
     */
    public function validatesSuccessfulResult($result) {       
        $expectedResult = [
            'candidate' => [
                'lastName' => 'Adebayo',
                'firstName' => 'Oluwatumininu',
                'middleName' => 'Adedayo',
                'candidateNumber' => '85982172FF',
                'dob' => '08 December 1996',
                'age' => '21',
                'lga' => 'ABEOKUTA-SOUTH',
                'state' => 'Ogun',
                'examNumber' => 'C47311086'
            ],
            'result' => [
                'result' => [
                    ['subject' => 'Use of English', 'score' => 49],
                    ['subject' => 'Mathematics', 'score' => 49],
                    ['subject' => 'Yoruba', 'score' => 56],
                    ['subject' => 'Commerce', 'score' => 50]
                ],
                'total' => 204
            ]
        ];


        $this->assertSame($expectedResult, $result->toArray());
    }
    
}
