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
use Symfony\Component\BrowserKit\Client;

/**
 * Description of ResultCheckerTest
 *
 * @author Oluwatunmise Akinsola
 */
class ResultCheckerTest extends TestCase {
    
    /**
     *
     * @var Client 
     */
    private $client;
    
    /**
     *
     * @var ResultChecker 
     */
    private $checker;
    
    /**
     * Set up function
     */
    public function setUp() {
        $this->client = $this->getMockForAbstractClass(Client::class);    
        $requiredFields = [
                            'exam_num' => 'int',
                            'exam_year' => 'int',
                            'exam_type' => 'string',
                            'card_pin' => 'int',
                            'card_serial' => 'string'
                        ];
        $this->checker = $this->getMockForAbstractClass(ResultChecker::class, [$this->client, 'waec', $requiredFields], '', true, true, true);
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
     * @dataProvider validationDataProvider
     */
    public function validateRequiredFields($data, $exception) {
        $this->expectException($exception);
        $this->checker->getResult($data);
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
    public function validationDataProvider() {
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
}
