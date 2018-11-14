<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ResultChecker\Exception;

use RuntimeException;

/**
 * Description of ResultProcessingException
 *
 * @author Oluwatunmise Akinsola 
 */
class ResultProcessingException extends RuntimeException {
    
    /**
     *
     * @var array
     */
    private $errorInfo;
    
    public function __construct(array $errorInfo) {
        parent::__construct($errorInfo['message']);
        
        $this->errorInfo = $errorInfo;
    }
    
    public function getType() {
        return $this->errorInfo['type'];
    }
}
