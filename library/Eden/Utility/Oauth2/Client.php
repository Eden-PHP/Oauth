<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility\Oauth2;

/**
 * Oauth2 client class
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Client extends Base 
{
    const INSTANCE = 1;

    protected $responseType = self::CODE;
    protected $accessType = self::ONLINE;
    protected $approvalPrompt = self::FORCE;
    protected $grantType = 'authorization_code';

    /**
     * Set auth for offline access
     *
     * @return this
     */
    public function forOffline()
    {
        $this->accessType = self::OFFLINE;

        return $this;
    }

    /**
     * Set auth for online access
     *
     * @return this
     */
    public function forOnline()
    {
        $this->accessType = self::ONLINE;

        return $this;
    }

    /**
     * Set auth for online access
     *
     * @return this
     */
    public function approvalPromptToAuto()
    {
        $this->approvalPrompt = self::AUTO;

        return $this;
    }

    /**
     * Returns website login url
     *
     * @param string|null
     * @param string|null
     * @return url
     */
    public function getLoginUrl($scope = NULL, $display = NULL)
    {
        //argument test
        Argument::i()
            ->test(1, 'string', 'array', 'null')	//argument 1 must be a string, array or null
            ->test(2, 'string', 'array', 'null');	//argument 2 must be a string, array or null

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

        return $this->getLoginUrl($query);
    }

    /**
     * Returns website login url
     *
     * @param string*
     * @return array
     */
    public function getAccess($code, $refreshToken = false)
    {
        //argument testing
        Argument::i()
            ->test(1, 'string')	//argument 1 must be a string
            ->test(2, 'bool');  //argument 2 must be a boolean

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

        return $this->getAccess($query, $code, $refreshToken);
    }
}
