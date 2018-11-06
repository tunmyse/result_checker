<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Tests;

use PHPUnit\Framework\TestCase;
use ResultChecker\Exception\InvalidArgumentException;
use ResultChecker\Exception\MissingFieldException;
use ResultChecker\ResultChecker;
use ResultChecker\ResultInterface;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ResultCheckerTest
 *
 * @author Oluwatunmise Akinsola
 */
class ResultCheckerTest extends TestCase {
    
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
        
        $requiredFields = [
                            'exam_num' => 'int',
                            'exam_year' => 'int',
                            'exam_type' => 'string',
                            'card_pin' => 'int',
                            'card_serial' => 'string'
                        ];
        $this->checker = $this->getMockForAbstractClass(ResultChecker::class, [$this->client, 'waec', $requiredFields], '', true, true, true, ['getRequestInfo', 'parseResponse']);
    }
    
    /**
     * @test
     */
    public function typeMatchesConstructorArgument() {
        $type = 'waec';               
        $this->assertSame($type, $this->checker->getType());
    }
    
    /**
     * @test
     * @dataProvider supportTestProvider
     */
    public function checksTypeSupport($type, $support) {              
        $this->assertSame($support, $this->checker->supports($type));
    }
    
    /**
     * @test
     * @dataProvider invalidValidationDataProvider
     */
    public function validatesRequiredFields($data, $exception) {
        $this->expectException($exception);
        $this->checker->getResult($data);
    }
    
    /**
     * @test
     */
    public function callsClientWithRequestInfo() {
        $requestInfo = ['url' => 'https://www.waecdirect.org', 'method' => 'POST', 'params' => []];
        $crawler = $this->createMock(Crawler::class);
        
        $this->checker
                ->expects($this->once())
                ->method('getRequestInfo')
                ->willReturn($requestInfo);
        
        $this->client
                ->expects($this->once())
                ->method('request')
                ->with($requestInfo['method'], $requestInfo['url'], $requestInfo['params'])
                ->willReturn($crawler);
        $this->checker->getResult($this->validData);
    }
            
    /**
     * @test
     */
    public function returnsResultInterface() {
        $requestInfo = ['url' => 'https://www.waecdirect.org', 'method' => 'POST', 'params' => []];
        $crawler = $this->createMock(Crawler::class);
        $result = $this->createMock(ResultInterface::class);
        
        $this->checker
                ->expects($this->once())
                ->method('getRequestInfo')
                ->willReturn($requestInfo);
        
        $this->client
                ->expects($this->once())
                ->method('request')
                ->with($requestInfo['method'], $requestInfo['url'], $requestInfo['params'])
                ->willReturn($crawler);
        
        $this->checker
                ->expects($this->once())
                ->method('parseResponse')
                ->with($crawler)
                ->willReturn($result);
        
        $return = $this->checker->getResult($this->validData);
        $this->assertInstanceOf(ResultInterface::class, $return);
    }
      
    /**
     * @test
     */
    public function callsRequestInfoWithRequestData() {
        $requestInfo = ['url' => 'https://www.waecdirect.org', 'method' => 'POST', 'params' => []];
        $crawler = $this->createMock(Crawler::class);
        $result = $this->createMock(ResultInterface::class);
        
        $this->checker
                ->expects($this->once())
                ->method('getRequestInfo')
                ->with($this->validData)
                ->willReturn($requestInfo);
        
        $this->client
                ->method('request')
                ->willReturn($crawler);
        
        $this->checker
                ->method('parseResponse')
                ->willReturn($result);
        
        $this->checker->getResult($this->validData);
    }
    
    /**
     * @test
     * @dataProvider invalidRequestInfoDataProvider
     */
    public function validatesRequestInfo($return, $exception, $message) {
        $this->checker
                ->expects($this->any())
                ->method('getRequestInfo')
                ->willReturn($return);
        
        $this->expectException($exception);
        $this->expectExceptionMessage($message);
        
        $this->checker->getResult($this->validData);
    }

    /**
     * @return array
     */
    public function supportTestProvider() {
        return [['WAEC', true], ['waec', true], ['JAMB', false], ['NECO', false]];
    }   

    /**
     * @return array
     */
    public function invalidValidationDataProvider() {
        return [
            [
                [
                    'exam_year' => '2018',
                    'exam_type' => 'MAY/JUN',
                    'card_pin' => '76890-0878654',
                    'card_serial' => 'NyEtytuy5679685743'
                ],
                MissingFieldException::class
            ], 
            [
                [
                    'exam_num' => '76543456781234567890',
                    'exam_year' => '2018',
                    'exam_type' => 'MAY/JUN',
                    'card_pin' => '00878654',
                    'card_serial' => 85
                ],
                InvalidArgumentException::class
            ], 
            [
                [
                    'exam_num' => '87980hhh',
                    'exam_year' => '2018',
                    'exam_type' => 'MAY/JUN',
                    'card_pin' => '00878654',
                    'card_serial' => 'kojnhgvyutvutb'
                ],
                InvalidArgumentException::class
            ]
        ];
    }
    
    /**
     * @return array
     */
    public function invalidRequestInfoDataProvider() {
        return [            
            [
                [],
                MissingFieldException::class,
                'The parameter(s) "url", "method", "params" are required but are missing!'
                
            ],
            [
                ['url' => '', 'method' => 'POST', 'params' => []],
                InvalidArgumentException::class,
                'The parameter "url" in not a valid url!'
            ], 
            [
                ['url' => 'https://www.waecdirect.org', 'method' => 'PST', 'params' => []],
                InvalidArgumentException::class,
                'The parameter "method" must be a valid HTTP method and either of ["GET", "POST"]!'
            ], 
            [
                ['url' => 'https://www.waecdirect.org', 'method' => 'POST', 'params' => ''],
                InvalidArgumentException::class,
                'The parameter "params" must be an array!'
            ]
        ];
    }
}
