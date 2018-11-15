<?php

namespace ResultChecker\Result;

use ResultChecker\Result\CandidateInterface;
use ResultChecker\Result\AgeInterface;
use ResultChecker\Result\ScoreInterface;
use ResultChecker\Result\StateInterface;
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
 * Description of JambResult
 *
 * @author Oluwatunmise Akinsola
 */
class JambResult implements ResultInterface, CandidateInterface, AgeInterface, ScoreInterface, StateInterface {
            
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
        return $this->candidate['year'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getResult() {
        return $this->result['result'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getTotalScore() {
        return $this->result['total'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getFirstName() {
        return $this->candidate['firstName'];
    }

    /**
     * {@inheritDoc}
     */
    public function getLastName() {
        return $this->candidate['lastName'];        
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddleName() {
        return $this->candidate['middleName'];
    }

    /**
     * {@inheritDoc}
     */
    public function getCandidateNumber() {
        return $this->candidate['candidateNumber'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getAge() {
       return $this->candidate['age'];
    }

    /**
     * {@inheritDoc}
     */
    public function getDob() {
       return $this->candidate['dob'];        
    }
    
    /**
     * {@inheritDoc}
     */
    public function getLga() {
       return $this->candidate['lga'];     
    }

    /**
     * {@inheritDoc}
     */
    public function getState() {
       return $this->candidate['state'];     
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
