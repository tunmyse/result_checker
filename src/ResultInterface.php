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

use ResultChecker\Exception\ErrorResultException;

/**
 *
 * @author Oluwatunmise Akinsola
 */
interface ResultInterface {
    
    /**
     * Get the subjects and corresponding grade information in the result
     * 
     * @return array returns array containing subject and grade.
     * @throws ErrorResultException
     */
    public function getResult();
    
    /**
     * Get the exam number of the exam candidate
     * 
     * @return string exam number of the candidate.
     */
    public function getExamNumber();
    
    /**
     * Get the year the candidate wrote the exam 
     * 
     * @return int The exam year.
     */
    public function getExamYear();
    
    /** 
     * Get all the information contained in this Result object
     * 
     * @return array An array containing the candidate and result information
     */
    public function toArray();
}
