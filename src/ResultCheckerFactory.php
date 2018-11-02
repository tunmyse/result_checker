<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker;

use Goutte\Client;
use ResultChecker\Checker\JambResultChecker;
use ResultChecker\Checker\NabtebResultChecker;
use ResultChecker\Checker\NecoResultChecker;
use ResultChecker\Checker\WaecResultChecker;
use ResultChecker\Exception\InvalidArgumentException;
use ResultChecker\Exception\UnsupportedTypeException;
use ResultChecker\ResultCheckerInterface;

/**
 * Description of ResultCheckerFactory
 *
 * @author Oluwatunmise
 */
class ResultCheckerFactory {
    
    public function __construct() {
        $client = new Client();
        $this->checkers[] = new WaecResultChecker($client);
        $this->checkers[] = new NecoResultChecker($client);
        $this->checkers[] = new JambResultChecker($client);
        $this->checkers[] = new NabtebResultChecker($client);
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
