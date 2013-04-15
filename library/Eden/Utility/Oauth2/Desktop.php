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
 * Oauth2 desktop class
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Desktop extends Base 
{
    protected $responseType = self::CODE;
    protected $grantType = 'authorization_code';

    /**
     * Returns website login url
     *
     * @param string|null
     * @param string|null
     * @return string
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
          'redirect_uri' => $this->redirect);

        return $this->getLoginUrl($query);

    }

    /**
     * Returns website login url
     *
     * @param string*
     * @return array
     */
    public function getAccess($code)
    {
        //argument 1 must be a string
        Argument::i()->test(1, 'string');

        //populate fields
        $query = array(
            'client_id'		=> $this->client,
            'client_secret'	=> $this->secret,
            'redirect_uri'	=> $this->redirect,
            'grant_type'	=> $this->grantType);

        return $this->getAccess($query, $code);
    }
}
