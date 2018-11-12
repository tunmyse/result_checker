<?php

namespace ResultChecker\Result;

use ResultChecker\ResultInterface;

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of WaecResult
 *
 * @author Oluwatunmise Akinsola
 */
class WaecResult implements ResultInterface {
    
    
    
    /**
     *
     * @var array 
     */
    private $candidate;
    
    /**
     *
     * @var array
     */
    private $result;
    
    /**
     *
     * @var array
     */
    private $error;
    
    public function __construct($candidateInfo, $resultInfo, $errorInfo = null) {
        $this->error = $errorInfo;$candidateInfo;
        $this->candidate = $candidateInfo;
        $this->result = $resultInfo;
    }
    
    /**
     * {@inheritDoc}
     */
    public function hasError() {
        return !empty($this->error) || isset($this->error);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorType(): string {
        if($this->hasError())
            return $this->error['type'];
            
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray() {
        return [
            'candidate' => $this->candidate,
            'result' => $this->result
        ];
    }

}
