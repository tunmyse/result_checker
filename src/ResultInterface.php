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
interface ResultInterface {
    
    /**
     * Determine if the result response was an error response
     * 
     * @return boolean returns true if response is an error, false otherwise
     */
    public function hasError();
    
    /**
     * Get the error type 
     * 
     * @return string returns the error type string, null otherwise
     */
    public function getErrorType();
}
