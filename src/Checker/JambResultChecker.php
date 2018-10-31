<?php

/*
 * This file is part of the Result Checker package.
 *
 * (c) Oluwatunmise Akinsola <akinsolatunmise@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tunmyse\ResultChecker\Checker;

use Tunmyse\ResultChecker\ResultCheckerInterface;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise
 */
class JambResultChecker implements ResultCheckerInterface {
    
    /**
     *
     * @var string 
     */
    private $type = 'jamb';
    
    /**
     * 
     * @return string
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * 
     * @
     */
    public function supports($type) {
        if(trim(strtolower($type)) == $this->getType())
            return true;
        
        return false;
    }

}
