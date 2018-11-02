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

use ResultChecker\ResultCheckerInterface;
use Symfony\Component\BrowserKit\Client;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise Akinsola
 */
abstract class ResultChecker implements ResultCheckerInterface {
    
    /**
     *
     * @var Client 
     */
    protected $client;
    
    public function __construct(Client $client) {
        
    }
    /**
     *
     * @var string 
     */
    protected $type;
    
    /**
     * 
     */
    public function getResult(array $data) {
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * {@inheritDoc}
     */
    public function supports($type) {
        if(trim(strtolower($type)) == $this->getType())
            return true;
        
        return false;
    }
    
    /**
     * Validates examination information
     * 
     * @param array $data Examination information
     * 
     * @return true | InvalidArgumentException Returns true is parameters are valid, InvalidArgumentException otherwise
     */
    abstract protected function validate(array $data);
    
    /**
     * Parse response from the examination body
     * 
     * @param type $name Description
     * 
     * @return type Description
     */
    abstract protected function parseResponse();
}
