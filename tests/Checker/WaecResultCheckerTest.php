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
use ResultChecker\Checker\WaecResultChecker;
use ResultChecker\Exception\ResultMismatchException;
use ResultChecker\Exception\ResultProcessingException;
use ResultChecker\Result\WaecResult;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of WaecResultCheckerTest
 *
 * @author Oluwatunmise Akinsola
 */
class WaecResultCheckerTest extends TestCase {
    
    private $client;
    
    private $checker;
    
    private $validData;
    
    /**
     * Set up function
     */
    public function setUp() {
        
        $this->client = $this->getMockForAbstractClass(Client::class, [], '', true, true, true, ['request']); 
        $this->validData = [
                    'exam_num' => '4310210052',
                    'exam_year' => '2016',
                    'exam_type' => 'MAY/JUN',
                    'card_pin' => '277333507864',
                    'card_serial' => 'NRC759930930TR'
                ];
        
        $this->checker = $this->getMockBuilder(WaecResultChecker::class)
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
            'ExamNumber' => $this->validData['exam_num'],
            'ExamYear' => $this->validData['exam_year'],
            'ExamType' => $this->validData['exam_type'],
            'serial' => $this->validData['card_serial'],
            'pin' => $this->validData['card_pin']
        ];
        
        $crawler = $this->createPartialMock(Crawler::class, ['getUri']);
        $crawler->expects($this->any())
                ->method('getUri')
                ->willReturn('https://www.waecdirect.org/ResultError.aspx?errTitle=Null Candidate&errMsg=Please re-submit your exam details');
                                
        $this->client
                ->expects($this->once())
                ->method('request')
                ->with('GET', 'https://www.waecdirect.org/DisplayResult.aspx?'. http_build_query($reqData), $reqData)                
                ->willReturn($crawler);
        
        $this->expectException(ResultProcessingException::class);
        $this->checker->getResult($this->validData);                
    }
    
    /**
     * @test
     * @dataProvider errorDataProvider
     */
    public function checkResponseForError($url, $errorType) {    
        $crawler = $this->createPartialMock(Crawler::class, ['getUri']);
        $crawler->expects($this->exactly(2))
                ->method('getUri')
                ->willReturn($url);
                
        $this->client
                ->expects($this->once())
                ->method('request')               
                ->willReturn($crawler);
        
        try {
            $this->checker->getResult($this->validData); 
            $this->fail();
        }catch (ResultProcessingException $ex) {
            $this->assertSame($errorType, $ex->getType());
        }
    }
    
    /**
     * @test
     */
    public function checksResultIsForCandidate() {  
        require 'waec_resp.php';
        $crawler = new Crawler($waecText, 'https://www.waecdirect.org/DisplayResult.aspx');
        $this->validData['exam_num'] = '4310210059';
        
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
        require 'waec_resp.php';
        $realCrawler = new Crawler($waecText, 'https://www.waecdirect.org/DisplayResult.aspx');
                
        $crawler = $this->createPartialMock(Crawler::class, ['filter', 'getUri']);
        $crawler->expects($this->once())
                ->method('getUri')
                ->willReturn('https://www.waecdirect.org/DisplayResult.aspx');
           
        $this->client
                ->method('request')               
                ->willReturn($crawler);
        
        $crawler->expects($this->exactly(2))
                ->method('filter')
                ->withConsecutive(['#tbCandidInfo tr'], ['#tbSubjectGrades tr'])
                ->willReturnOnConsecutiveCalls($realCrawler->filter('#tbCandidInfo tr'), $realCrawler->filter('#tbSubjectGrades tr'));
        
        
        $result = $this->checker->getResult($this->validData);       
        $this->assertInstanceOf(WaecResult::class, $result);
        
        return $result;
    }    
    
    /**
     * @test
     * @depends clone returnsValidResultType
     */
    public function validatesSuccessfulResult($result) {       
        $expectedResult = [
                            'candidate' => [
                                "examNumber" => "4310210052",
                                "lastName" => "CHUKWU",
                                "firstName" => "ERICK",
                                "middleName" => "EMEKA",
                                "period" => "MAY/JUNE",
                                "type" => "WASSCE",
                                "year" => "2011"
                            ],
                            'result' => [
                                ['subject' => 'CHRISTIAN RELIGIOUS KNOWLEDGE','grade' => 'D7'],
                                ['subject' => 'ECONOMICS','grade' => 'F9'],
                                ['subject' => 'GOVERNMENT','grade' => 'C6'],
                                ['subject' => 'LITERATURE IN ENGLISH','grade' => 'C5'],
                                ['subject' => 'ENGLISH LANGUAGE','grade' => 'E8'],
                                ['subject' => 'YORUBA LANGUAGE','grade' => 'C6'],
                                ['subject' => 'MATHEMATICS','grade' => 'C6'],
                                ['subject' => 'AGRICULTURAL SCIENCE','grade' => 'B3'],
                                ['subject' => 'BIOLOGY','grade' => 'D7']
                            ]
                        ];
        $this->assertSame($expectedResult, $result->toArray());
    }
    
    public function errorDataProvider() {
        // TODO get error for new card, wrong exam number
        return [
            'other error' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=Null Candidate&errMsg=Please re-submit your exam details',
                WaecResultChecker::OTHER_ERROR
            ],
            'invalid card' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=INVALID SCRATCH CARD DETAIL&errMsg=INVALID SCRATCH CARD DETAIL',
                WaecResultChecker::INVALID_CARD
            ],
            'exhauted card' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=The card usage has exceeded the maximum allowed. Please purchase another card&errMsg=The card usage has exceeded the maximum allowed. Please purchase another card',
                WaecResultChecker::EXHAUSTED_CARD
            ],
            'wrong exam type' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=RESULT NOT AVAILABLE FOR THIS CANDIDATE IN THE SPECIFIED YEAR AND EXAMS DIET.&errMsg=RESULT NOT AVAILABLE FOR THIS CANDIDATE IN THE SPECIFIED YEAR AND EXAMS DIET',
                WaecResultChecker::WRONG_EXAM_TYPE
            ],
            'wrong exam year' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=RESULT CHECKER CARD HAS BEEN USED BY ANOTHER CANDIDATE&errMsg=RESULT CHECKER CARD HAS BEEN USED BY ANOTHER CANDIDATE',
                WaecResultChecker::WRONG_EXAM_YEAR
            ],
            'wrong exam type' => [
                'https://www.waecdirect.org/ResultError.aspx?errTitle=CARD ALREADY USED BY ANOTHER CANDIDATE&errMsg=CARD ALREADY USED BY ANOTHER CANDIDATE',
                WaecResultChecker::CARD_ALREADY_USED
            ]
        ];
    }
}
