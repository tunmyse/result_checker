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

/**
 *
 * @author Oluwatunmise Akinsola
 */
interface ResultCheckerInterface {
    
    
    /**
     * Returns the type supported by this result checker
     * 
     * @return string
     */
    public function getType();
            
    /**
     * Determines if the exam type is supported by this result checker.
     *
     * @param string type Exam type
     *
     * @return bool True if the type can be checked, false otherwise
     */
    public function supports($type);
    
    /**
     * Get examination result from examination body.
     *
     * @param array data Examination information
     *
     * @return ResultInterface 
     * @thows ResultProcessingException
     */
    public function getResult(array $data);
}
