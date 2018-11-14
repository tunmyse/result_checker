<?php

namespace ResultChecker\Result;

use ResultChecker\Result\CandidateInterface;
use ResultChecker\Result\ExaminationInformationInterface;
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
class WaecResult implements ResultInterface, CandidateInterface, ExaminationInformationInterface {
            
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
        return $this->result;
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
        return $this->getExamNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getExamPeriod() {
        return $this->candidate['period'];
    }

    /**
     * {@inheritDoc}
     */
    public function getExamType() {        
        return $this->candidate['type'];
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
