<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Result;

/**
 *
 * @author Oluwatunmise Akinsola
 */
interface CandidateInterface {
    
    /**
     * Get the candidate's last name
     * 
     * @return string The candidate's last name
     */
    public function getLastName(); 
    
    /**
     * Get the candidate's first name
     * 
     * @return string The candidate's first name
     */
    public function getFirstName();    
    
    /**
     * Get the candidate's middle name
     * 
     * @return string The candidate's middle name
     */
    public function getMiddleName();  
    
    /**
     * Get the identification number assigned to the candidate
     * 
     * @return string The candidate's identification number
     */
    public function getCandidateNumber();
}
