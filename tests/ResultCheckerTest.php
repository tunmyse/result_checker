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
use Symfony\Component\BrowserKit\Client;
use ResultChecker\ResultChecker;

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
        $this->checker = $this->getMockForAbstractClass(ResultChecker::class, [$this->client], '', true, true, true, ['getType']);
    }
    
    /**
     * @test
     */
    public function isValidForSupportedType() {
        $type = 'WAEC';
        $this->checker->expects($this->any())
                ->method('getType')
                ->willReturn(strtolower($type));                
        $this->assertTrue($this->checker->supports($type));
    }
    
    /**
     * @test
     */
    public function isInvalidForUnsupportedType() {
        $checker = $this->getMockForAbstractClass(ResultChecker::class, [$this->client], '', true, true, true, ['getType']);
        $this->checker->expects($this->any())
                ->method('getType')
                ->willReturn('waec');                
        $this->assertFalse($this->checker->supports('JAMB'));
    }
}
