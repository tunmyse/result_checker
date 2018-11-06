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
use ResultChecker\ResultInterface;
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
                    'exam_num' => '76543456781234567890',
                    'exam_year' => '2018',
                    'exam_type' => 'MAY/JUN',
                    'card_pin' => '3877309200878654',
                    'card_serial' => 'NRC759930930TR'
                ];
        
        $this->checker = $this->getMockBuilder(WaecResultChecker::class)
                                ->setMethods(['parseResponse'])
                                ->enableOriginalConstructor()
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
        
        $crawler = $this->createMock(Crawler::class);
                
        $this->client
                ->expects($this->once())
                ->method('request')
                ->with('GET', 'https://www.waecdirect.org/DisplayResult.aspx', $reqData)                
                ->willReturn($crawler);
        
        $this->checker->getResult($this->validData);                
    }
}
