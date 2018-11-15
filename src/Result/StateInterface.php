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
interface StateInterface {
    
    /**
     * Get the candidate's state
     * 
     * @return string The candidate's state
     */
    public function getState();
    
    /**
     * Get the candidate's local government area
     * 
     * @return string The candidate's local government area
     */
    public function getLga();
}
