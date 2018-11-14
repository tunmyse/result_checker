<?php

namespace ResultChecker\Result;

use ResultChecker\ResultInterface;

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of WaecResult
 *
 * @author Oluwatunmise Akinsola
 */
class WaecResult implements ResultInterface {
            
    /**
     *
     * @var array 
     */
    private $candidate;
    
    /**
     *
     * @var array
     */
    private $result;
    
    public function __construct($candidateInfo, $resultInfo) {
        $this->candidate = $candidateInfo;
        $this->result = $resultInfo;
    }    

    /**
     * {@inheritDoc}
     */
    public function getExamNumber(){
        return $this->candidate['examNumber'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getExamYear() {
        $this->candidate['year'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getResult() {
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function toArray() {
        return [
            'candidate' => $this->candidate,
            'result' => $this->result
        ];      
    }

}
