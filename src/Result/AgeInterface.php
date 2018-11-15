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
interface AgeInterface {
    
    /**
     * Get the age of the candidate
     * 
     * @return int The age of the candidate
     */
    public function getAge();
    
    
    /**
     * Get the candidate's date of birth
     * 
     * @return int The age of the candidate
     */
    public function getDob();
}
