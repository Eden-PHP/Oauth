<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

use Eden\Utility\Oauth2\Client;
use Eden\Utility\Oauth2\Desktop;

/**
 * Oauth2 Factory class
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Oauth2 extends Base 
{
    const INSTANCE = 1;

    /**
     * Returns oauth 2 client side class
     *
     * @param *string The application client ID, can get through registration
     * @param *string The application secret, can get through registration
     * @param *string Your callback url or where do you want to redirect the user after authentication
     * @param *string The request url,  can get through registration
     * @param *string The access url,  can get through registration
     * @return Eden\Utility\Oauth\Client
     */
    public function client($client, $secret, $redirect, $requestUrl, $accessUrl)
    {
        //argument test
        Argument::i()
            ->test(1, 'string')	//argument 1 must be a string
            ->test(2, 'string')	//argument 2 must be a url
            ->test(3, 'url')    //argument 3 must be a url
            ->test(4, 'url')    //argument 4 must be a url
            ->test(5, 'url');   //argument 5 must be a url

        return Client::i($client, $secret, $redirect, $requestUrl, $accessUrl);
    }

    /**
     * Returns oauth 2 desktop class
     *
     * @param *string The application client ID, can get through registration
     * @param *string The application secret, can get through registration
     * @param *string Your callback url or where do you want to redirect the user after authentication
     * @param *string The request url,  can get through registration
     * @param *string The access url,  can get through registration
     * @return Eden\Utility\Oauth2\Client
     */
    public function desktop($client, $secret, $redirect, $requestUrl, $accessUrl)
    {
        //argument test
        Argument::i()
            ->test(1, 'string')	//argument 1 must be a string
            ->test(2, 'string')	//argument 2 must be a url
            ->test(3, 'url')    //argument 3 must be a url
            ->test(4, 'url')    //argument 4 must be a url
            ->test(5, 'url');   //argument 5 must be a url

        return Desktop::i($client, $secret, $redirect, $requestUrl, $accessUrl);
    }
} 