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
interface ExaminationInformationInterface {
        
    /**
     * Get the candidate's last name
     * 
     * @return string The candidate's last name
     */
    public function getExamPeriod(); 
    
    /**
     * Get the specific exam type for examination bodies that have different types
     * 
     * @return string The candidate's first name
     */
    public function getExamType();  
}
