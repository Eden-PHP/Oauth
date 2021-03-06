<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth2;

use Eden\Oauth\Base;
use Eden\Oauth\Argument;
use Eden\Oauth\Exception;

/**
 * Oauth2 Factory class
 *
 * @vendor   Eden
 * @package  Oauth
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Index extends Base
{
    /**
     * @const int INSTANCE Flag that designates singleton when using ::i()
     */
    const INSTANCE = 1;

    /**
     * Returns oauth 2 client side class
     *
     * @param *string $client     The application client ID, can get through registration
     * @param *string $secret     The application secret, can get through registration
     * @param *string $redirect   Your callback url or where do you want to redirect the user after authentication
     * @param *string $requestUrl The request url,  can get through registration
     * @param *string $accessUrl  The access url,  can get through registration
     *
     * @return Eden\Oauth\Oauth\Client
     */
    public function client($client, $secret, $redirect, $requestUrl, $accessUrl)
    {
        //argument test
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 2 must be a url
            ->test(2, 'string')
            //argument 3 must be a url
            ->test(3, 'url')
            //argument 4 must be a url
            ->test(4, 'url')
            //argument 5 must be a url
            ->test(5, 'url');

        return Client::i($client, $secret, $redirect, $requestUrl, $accessUrl);
    }

    /**
     * Returns oauth 2 desktop class
     *
     * @param *string $client     The application client ID, can get through registration
     * @param *string $secret     The application secret, can get through registration
     * @param *string $redirect   Your callback url or where do you want to redirect the user after authentication
     * @param *string $requestUrl The request url,  can get through registration
     * @param *string $accessUrl  The access url,  can get through registration
     *
     * @return Eden\Oauth\Oauth2\Client
     */
    public function desktop($client, $secret, $redirect, $requestUrl, $accessUrl)
    {
        //argument test
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 2 must be a url
            ->test(2, 'string')
            //argument 3 must be a url
            ->test(3, 'url')
            //argument 4 must be a url
            ->test(4, 'url')
            //argument 5 must be a url
            ->test(5, 'url');

        return Desktop::i($client, $secret, $redirect, $requestUrl, $accessUrl);
    }
}
