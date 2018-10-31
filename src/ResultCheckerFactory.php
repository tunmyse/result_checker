<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tunmyse\ResultChecker;

use Tunmyse\ResultChecker\Exception\InvalidArgumentException;
use Tunmyse\ResultChecker\Exception\UnsupportedTypeException;
use Tunmyse\ResultChecker\ResultCheckerInterface;
use Tunmyse\ResultChecker\Checker\WaecResultChecker;
use Tunmyse\ResultChecker\Checker\NecoResultChecker;
use Tunmyse\ResultChecker\Checker\JambResultChecker;
use Tunmyse\ResultChecker\Checker\NabtebResultChecker;

/**
 * Description of ResultCheckerFactory
 *
 * @author Oluwatunmise
 */
class ResultCheckerFactory {
    
    public function __construct() {
        $this->checkers[] = new WaecResultChecker;
        $this->checkers[] = new NecoResultChecker;
        $this->checkers[] = new JambResultChecker;
        $this->checkers[] = new NabtebResultChecker;
    }

    /**
     *
     * @var ResultCheckerInterface[] 
     */
    private $checkers = [];
    
    public function getResultChecker($type) {
        if(!is_string($type) || empty($type))
            throw new InvalidArgumentException("The value of 'type' must be a string and must not be empty!");
            
        foreach($this->checkers as $checker) {
            if ($checker->supports($type)) {
                return $checker;
            }
        }  
        
        throw new UnsupportedTypeException(sprintf("The '%s' exam type does not have a registered checker!", $type));
    }    
    
    public function addResultChecker(ResultCheckerInterface $checker) {
        $this->checkers[] = $checker;
    }
}
