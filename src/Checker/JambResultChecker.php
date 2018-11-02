<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Checker;

use ResultChecker\ResultChecker;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise
 */
class JambResultChecker extends ResultChecker {
    
    /**
     * 
     * @var string 
     */
    protected $type = 'jamb';

    protected function parseResponse() {
        
    }

    protected function validate(array $data) {
    
    }
}
