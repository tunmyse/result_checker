<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Tests\Result;

use PHPUnit\Framework\TestCase;
use ResultChecker\Result\WaecResult;

/**
 * Description of WaecResultTest
 *
 * @author Oluwatunmise Akinsola
 */
class WaecResultTest extends TestCase {
        
    private $resultData;
    
    private $validResult;
    
    /**
     * Set up function
     */
    public function setUp() {
        $this->resultData = [
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
                ['subject' => 'CHRISTIAN RELIGIOUS KNOWLEDGE', 'grade' => 'D7'],
                ['subject' => 'ECONOMICS', 'grade' => 'F9'],
                ['subject' => 'GOVERNMENT', 'grade' => 'C6'],
                ['subject' => 'LITERATURE IN ENGLISH', 'grade' => 'C5'],
                ['subject' => 'ENGLISH LANGUAGE', 'grade' => 'E8'],
                ['subject' => 'YORUBA LANGUAGE', 'grade' => 'C6'],
                ['subject' => 'MATHEMATICS', 'grade' => 'C6'],
                ['subject' => 'AGRICULTURAL SCIENCE', 'grade' => 'B3'],
                ['subject' => 'BIOLOGY', 'grade' => 'D7']
            ]
        ];
        
        $this->validResult = new WaecResult($this->resultData['candidate'], $this->resultData['result']);
    }
        
    /**
     * @test
     */
    public function validatesCandidateDetails() {   
        $this->assertSame($this->resultData['candidate']['firstName'], $this->validResult->getFirstName());
        $this->assertSame($this->resultData['candidate']['lastName'], $this->validResult->getLastName());
        $this->assertSame($this->resultData['candidate']['middleName'], $this->validResult->getMiddleName());
        $this->assertSame($this->resultData['candidate']['examNumber'], $this->validResult->getCandidateNumber());
    }
    
    /**
     * @test
     */
    public function validatesExamDetails() {   
        $this->assertSame($this->resultData['candidate']['examNumber'], $this->validResult->getExamNumber());
        $this->assertSame($this->resultData['candidate']['year'], $this->validResult->getExamYear());
        $this->assertSame($this->resultData['candidate']['type'], $this->validResult->getExamType());
        $this->assertSame($this->resultData['candidate']['period'], $this->validResult->getExamPeriod());
    }
    
    /**
     * @test
     */
    public function validatesResultDetails() {  
        $this->assertSame($this->resultData['result'], $this->validResult->getResult());
    }
}
