<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tunmyse\ResultChecker\Tests;

use PHPUnit\Framework\TestCase;
use Tunmyse\ResultChecker\Checker\WaecResultChecker;
use Tunmyse\ResultChecker\Exception\InvalidArgumentException;
use Tunmyse\ResultChecker\Exception\UnsupportedTypeException;
use Tunmyse\ResultChecker\ResultCheckerFactory;
use Tunmyse\ResultChecker\ResultCheckerInterface;

class ResultCheckerFactoryTest extends TestCase {    
    
    /**
     * @test
     * @dataProvider invalidTypeProvider
     */
    public function checksThatTypeIsValid($type) {
        $factory = new ResultCheckerFactory;
               
        $this->expectException(InvalidArgumentException::class);
        $factory->getResultChecker($type);
    }
    
    /**
     * @test
     */
    public function returnsValidCheckerInstance() {
        $type = 'WAEC';
        $testChecker = new WaecResultChecker();
        $factory = new ResultCheckerFactory;
        
        $factory->addResultChecker($testChecker);
        $resultChecker = $factory->getResultChecker($type);
        $this->assertInstanceOf(ResultCheckerInterface::class, $resultChecker);
    }
    
    /**
     * @test
     */
    public function throwsExceptionForUnsupportedExamType() {
        $type = 'GMAT';
        $testChecker = new WaecResultChecker();
        $factory = new ResultCheckerFactory;
        
        $factory->addResultChecker($testChecker);        
        $this->expectException(UnsupportedTypeException::class);
        $factory->getResultChecker($type);
    }
    
    /**
     * @test
     */
    public function addsNewCheckerToListOfCheckers() {
        $checker1 = $this->getMockChecker(1, 3, [['GMAT' , true], ['GRE', false]]);        
        $checker2 = $this->getMockChecker(1, 1, [['GRE', true], ['GMAT', false]]);
        $factory = new ResultCheckerFactory;
        
        try {
            $factory->getResultChecker('GMAT');    
            $this->fail();
        }catch(UnsupportedTypeException $ex) {}
        
        $factory->addResultChecker($checker1);         
        $returnedChecker = $factory->getResultChecker('GMAT');
        $this->assertSame('GMAT', $returnedChecker->getType());
        
        try {
            $factory->getResultChecker('GRE');    
            $this->fail();
        }catch(UnsupportedTypeException $ex) {}
        
        
        $factory->addResultChecker($checker2);  
        $returnedChecker = $factory->getResultChecker('GRE');
        $this->assertSame('GRE', $returnedChecker->getType());
    }
        
    /**
     * @test
     */
    public function isInitializedWithDefaultCheckers() {
        $factory = new ResultCheckerFactory;
        $defaultType = ['WAEC', 'NECO', 'NABTEB', 'JAMB'];
        
        foreach($defaultType as $type) {   
            $checker = $factory->getResultChecker($type); 
            $this->assertSame(strtolower($type), $checker->getType());
        }
        
    }
    
    private function getMockChecker($typeCount, $supportCount, $returnMap) {
        $checker = $this->createMock('Tunmyse\ResultChecker\ResultCheckerInterface');        
        $checker->expects($this->exactly($typeCount))->method('getType')->willReturn($returnMap[0][0]);
        $checker->expects($this->exactly($supportCount))->method('supports')->willReturnMap($returnMap);
        
        return $checker;
    }
    
    /**
     * @return array
     */
    public function invalidTypeProvider() {
        return [[''], [5], [null]];
    }

}