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
interface ScoreInterface {
    
    /**
     * Get the total score of this result
     * 
     * @return float The total value of all the subjects in this result
     */
    public function getTotalScore();
}
