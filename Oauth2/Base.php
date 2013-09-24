<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth2;

use Eden\Oauth\Argument;
use Eden\Curl\Base as Curl;
use Eden\Oauth\Base as OauthBase;

/**
 * Oauth2 abstract class
 *
 * @vendor Eden
 * @package Oauth
 * @author Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author Christian Blanquera cblanquera@openovate.com
 */
abstract class Base extends OauthBase 
{
    const CODE = 'code';
    const TOKEN = 'token';
    const ONLINE = 'online';
    const OFFLINE = 'offline';
    const AUTO = 'auto';
    const FORCE = 'force';
    const TYPE = 'Content-Type';
    const REQUEST = 'application/x-www-form-urlencoded';

    protected $client = null;
    protected $meta = array();
    protected $secret = null;
    protected $redirect = null;
    protected $state = null;
    protected $scope = null;
    protected $display	= null;
    protected $requestUrl = null;
    protected $accessUrl = null;

    protected $responseType = self::CODE;
    protected $approvalPrompt = self::AUTO;

    /**
     * Preset some tokens we need
     *
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return void
     */
    public function __construct($client, $secret, $redirect, $requestUrl, $accessUrl)
    {
        //argument test
        Argument::i()
			//argument 1 must be a string
            ->test(1, 'string')	
			//argument 2 must be a string
            ->test(2, 'string')	
			//argument 3 must be a url
            ->test(3, 'url')    
			//argument 4 must be a url
            ->test(4, 'url')    
			//argument 5 must be a url
            ->test(5, 'url');   

        $this->client       = $client;
        $this->secret       = $secret;
        $this->redirect     = $redirect;
        $this->requestUrl   = $requestUrl;
        $this->accessUrl    = $accessUrl;
    }

    /**
     * Returns the meta of the last call
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set auth to auto approve
     *
     * @return Eden\Oauth\Oauth2\Base
     */
    public function autoApprove()
    {
        $this->approvalPrompt = self::AUTO;

        return $this;
    }

    /**
     * Set auth for force approve
     *
     * @return Eden\Oauth\Oauth2\Base
     */
    public function forceApprove()
    {
        $this->approvalPrompt = self::FORCE;

        return $this;
    }

    /**
     * Set state
     *
     * @param *string
     * @return this
     */
    public function setState($state)
    {
        //argument 1 must be a string
        Argument::i()->test(1, 'string');

        $this->state = $state;

        return $this;
    }

    /**
     * Set scope
     *
     * @param *string|array
     * @return this
     */
    public function setScope($scope)
    {
        //argument 1 must be a string or array
        Argument::i()->test(1, 'string', 'array');

        $this->scope = $scope;

        return $this;
    }

    /**
     * Set display
     *
     * @param *string|array
     * @return this
     */
    public function setDisplay($display)
    {
        //argument 1 must be a string or array
        Argument::i()->test(1, 'string', 'array');

        $this->display = $display;

        return $this;
    }

    /**
     * Check if the response is json format
     *
     * @param *string
     * @return boolean
     */
    public function isJson($string)
    {
        //argument 1 must be a string
        Argument::i()->test(1, 'string');

        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * abstract function for getting login url
     *
     * @param string|null
     *
     */
    abstract public function getLoginUrl($scope = null, $display = null);

    /**
     * Returns website login url
     *
     * @param string*
     * @return array
     */
    abstract public function getAccess($code);

    /**
     * Generates a login url to redirect to
     *
     * @param *string
     * @return string
     */
    protected function generateLoginUrl($query)
    {
        //if there is a scope
        if(!is_null($this->scope)) {
            //if scope is in array
            if(is_array($this->scope)) {
                $this->scope = implode(' ', $this->scope);
            }
            //add scope to the query
            $query['scope'] = $this->scope;
        }
        //if there is state
        if(!is_null($this->state)) {
            //add state to the query
            $query['state'] = $this->state;
        }
        //if there is display
        if(!is_null($this->display)) {
            //add state to the query
            $query['display'] = $this->display;
        }
        //generate a login url
        return $this->requestUrl.'?'.http_build_query($query);
    }


    /**
     * Returns an access token from server
     *
     * @param *string
     * @param string|null
     * @param *bool
     * @return string
     */
    protected function generateAccess($query, $code = null, $refreshToken)
    {
        //if there is a code
        if(!is_null($code)) {
            //if you only want to refresh a token
            if($refreshToken) {
                //put code in the query
                $query['refresh_token'] = $code;
            //else you want to request a token
            } else {
                //put code in the query
                $query[self::CODE] = $code;
            }
        }

        //set curl
        $curl = Curl::i()
          ->setUrl($this->accessUrl)
          ->verifyHost(false)
          ->verifyPeer(false)
          ->setHeaders(self::TYPE, self::REQUEST)
          ->setPostFields(http_build_query($query));

        $result =  $curl->getResponse();

        $this->meta	= $curl->getMeta();
        $this->meta['query'] = $query;
        $this->meta['url'] = $this->accessUrl;
        $this->meta['response']	= $result;

        //check if results is in JSON format
        if($this->isJson($result)) {
            //if it is in json, lets json decode it
            $response =  json_decode($result, true);
        //else its not in json format
        } else {
            //parse it to make it an array
             parse_str($result, $response);
        }

        return $response;
    }
}