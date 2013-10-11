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

/**
 * Oauth2 client class
 *
 * @vendor Eden
 * @package Oauth
 * @author Christian Symon M. Buenavista <sbuenavista@openovate.com>
 * @author Christian Blanquera <cblanquera@openovate.com>
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Client extends Base 
{
    const INSTANCE = 1;

    protected $responseType = self::CODE;
    protected $accessType = self::ONLINE;
    protected $approvalPrompt = self::FORCE;
    protected $grantType = 'authorization_code';

    /**
     * Sets auth for offline access.
     *
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function forOffline()
    {
        $this->accessType = self::OFFLINE;

        return $this;
    }

    /**
     * Sets auth for online access.
     *
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function forOnline()
    {
        $this->accessType = self::ONLINE;

        return $this;
    }

    /**
     * Sets approval prompt to auto.
     *
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function approvalPromptToAuto()
    {
        $this->approvalPrompt = self::AUTO;

        return $this;
    }
    
    /**
     * Sets approval prompt to force.
     * 
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function approvalPromptToFore()
    {
        $this->approvalPrompt = self::FORCE;

        return $this;
    }
    
    /**
     * Sets response type to code.
     * 
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function responseTypeToCode()
    {
        $this->responseType = self::CODE;

        return $this;
    }
    
    /**
     * Sets response type to token.
     * 
     * @return \Eden\Oauth\Oauth2\Client
     */
    public function responseTypeToToken()
    {
        $this->responseType = self::TOKEN;

        return $this;
    }

    /**
     * Returns website login url.
     *
     * @param string|null
     * @param string|null
     * @return url
     */
    public function getLoginUrl($scope = null, $display = null)
    {
        //argument test
        Argument::i()
			//argument 1 must be a string, array or null
            ->test(1, 'string', 'array', 'null')	
			//argument 2 must be a string, array or null
            ->test(2, 'string', 'array', 'null');	

        //if scope in not null
        if(!is_null($scope)) {
            //lets set the scope
            $this->setScope($scope);
        }
        //if display in not null
        if(!is_null($display)) {
            //lets set the display
            $this->setDisplay($display);
        }

        //populate fields
        $query = array(
          'response_type' => $this->responseType,
          'client_id' => $this->client,
          'redirect_uri' => $this->redirect,
          'access_type' => $this->accessType,
          'approval_prompt'	=> $this->approvalPrompt);

        return $this->generateLoginUrl($query);
    }

    /**
     * Returns website login url.
     *
     * @param string*
     * @return array
     */
    public function getAccess($code, $refreshToken = false)
    {
        //argument testing
        Argument::i()
			//argument 1 must be a string
            ->test(1, 'string')	
			//argument 2 must be a boolean
            ->test(2, 'bool');  

        //if you want to refresh a token only
        if($refreshToken) {
            //populate fields
            $query = array(
                'client_id'		=> $this->client,
                'client_secret'	=> $this->secret,
                'grant_type'	=> 'refresh_token');
        } else {
            //populate fields
            $query = array(
                'client_id'		=> $this->client,
                'client_secret'	=> $this->secret,
                'redirect_uri'	=> $this->redirect,
                'grant_type'	=> $this->grantType);
        }

        return $this->generateAccess($query, $code, $refreshToken);
    }
}
