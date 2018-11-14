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

use ResultChecker\Exception\InvalidArgumentException;
use ResultChecker\Exception\MissingFieldException;
use ResultChecker\ResultCheckerInterface;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ResultChecker
 *
 * @author Oluwatunmise Akinsola
 */
abstract class ResultChecker implements ResultCheckerInterface {
    
    /**
     *
     * @var Client 
     */
    private $client;
    
    /**
     *
     * @var string 
     */
    private $type;
    
    /**
     *
     * @var array 
     */
    private $requiredFields;
    
    public function __construct(Client $client, $type, array $requiredFields) {
        $this->client = $client;
        $this->type = $type;
        $this->requiredFields = $requiredFields;        
    } 
    
    /**
     * {@inheritDoc}
     */
    public function getResult(array $data) {
        $this->validate($data);
        $requestInfo = $this->getRequestInfo($data);
        
        $diffArray = array_diff(['url', 'method', 'params'], array_keys($requestInfo));
        
        if(count($diffArray) > 0) {
            throw new MissingFieldException(sprintf('The parameter(s) "%s" are required but are missing!', implode('", "', $diffArray)));
        }
        
        if(!filter_var($requestInfo['url'], FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('The parameter "url" in not a valid url!');
        }
        
        if(!isset($requestInfo['method']) || !in_array(strtolower($requestInfo['method']), ['get', 'post'])) {
            throw new InvalidArgumentException('The parameter "method" must be a valid HTTP method and either of ["GET", "POST"]!');
        }
        
        if(!is_array($requestInfo['params'])) {
            throw new InvalidArgumentException('The parameter "params" must be an array!');
        }        
        
        $crawler = $this->makeRequest($this->client, $requestInfo);
        
        return $this->parseResponse($crawler);
    }    
    
    /**
     * {@inheritDoc}
     */ 
    public function getType() {
        return $this->type;
    }
    
    /**
     * {@inheritDoc}
     */
    public function supports($type) {
        if(trim(strtolower($type)) == $this->getType())
            return true;
        
        return false;
    }
    
    /**
     * Validates examination information
     * 
     * @param array $data Examination information
     * 
     * @return InvalidArgumentException | MissingFieldException
     */
    protected function validate(array $data) {
        $diffArray = array_diff(array_keys($this->requiredFields), array_keys($data));
        if(count($diffArray) > 0) {
            throw new MissingFieldException(sprintf('The following field(s) "%s" are required but are missing!', implode('", "', $diffArray)));
        }
        
        foreach($this->requiredFields as $field => $type) {
            switch($type) {
                case 'int':
                    if(!is_numeric($data[$field])) {
                        throw new InvalidArgumentException(sprintf('The "%s" field should be an integer!', $field));
                    }
                    break;
                    
                case 'string':
                    if(!is_string($data[$field])) {
                        throw new InvalidArgumentException(sprintf('The "%s" field should be an integer!', $field));
                    }
                    break;
                    
                default:
                    break;
            }
        }
    }
        
    /**
     * Make the request to get the result data
     * 
     * @param Client $client Description
     * @param array $requestInfo Description
     * @return Crawler Crawler object containing the exam response 
     */
    protected function makeRequest(Client $client, $requestInfo) {             
        return $client->request($requestInfo['method'], $requestInfo['url'], $requestInfo['params']);
    }
    
    /**
     * Returns the information required to make result request
     * 
     * @param array $requestData 
     * 
     * @return array Array containing request information
     */
    abstract protected function getRequestInfo(array $requestData);
    
    /**
     * Parse response from examination body
     * 
     * @param Crawler $crawler Crawler object containing response content
     * 
     * @return type ResultInterface
     */
    abstract protected function parseResponse(Crawler $crawler);
}
