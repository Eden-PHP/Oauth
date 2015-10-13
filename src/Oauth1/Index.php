<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth1;

use Eden\Oauth\Base;
use Eden\Oauth\Argument;
use Eden\Oauth\Exception;

/**
 * Oauth Factory; A summary of 2-legged and 3-legged OAuth
 * which can generally connect to any properly implemented
 * OAuth server.
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
     * Returns the oauth consumer class
     *
     * @param *string
     * @param *string
     * @param *string
     *
     * @return Eden\Oauth\Oauth1\Consumer
     */
    public function consumer($url, $key, $secret)
    {
        Argument::i()
            //argument 1 must be a string
            ->test(1, 'string')
            //argument 2 must be a string
            ->test(2, 'string')
            //argument 3 must be a string
            ->test(3, 'string');
            
        return Consumer::i($url, $key, $secret);
    }
    
    /**
     * Returns an access token given the requiremets
     * GET, HMAC-SHA1
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getHmacGetAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to get
            ->setMethodToGet()
             //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * GET, HMAC-SHA1, use Authorization Header
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getHmacGetAuthorizationAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to get
            ->setMethodToGet()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * GET, HMAC-SHA1, use Authorization Header
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getHmacGetAuthorizationRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to get
            ->setMethodToGet()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * GET, HMAC-SHA1
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getHmacGetRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to get
            ->setMethodToGet()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
                //get the token
            })->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * POST, HMAC-SHA1
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getHmacPostAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to post
            ->setMethodToPost()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * POST, HMAC-SHA1, use Authorization Header
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getHmacPostAuthorizationAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to post
            ->setMethodToPost()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * POST, HMAC-SHA1, use Authorization Header
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getHmacPostAuthorizationRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to post
            ->setMethodToPost()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * POST, HMAC-SHA1
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getHmacPostRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to post
            ->setMethodToPost()
            //set method to HMAC-SHA1
            ->setSignatureToHmacSha1()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * GET, PLAINTEXT
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getPlainGetAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to get
            ->setMethodToGet()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * GET, PLAINTEXT, use Authorization Header
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getPlainGetAuthorizationAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to get
            ->setMethodToGet()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * GET, PLAINTEXT, use Authorization Header
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getPlainGetAuthorizationRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to get
            ->setMethodToGet()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * GET, PLAINTEXT
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getPlainGetRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to get
            ->setMethodToGet()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * POST, PLAINTEXT
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getPlainPostAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to post
            ->setMethodToPost()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns an access token given the requiremets
     * POST, PLAINTEXT, use Authorization Header
     *
     * @param *string     $url         url
     * @param *string     $key         consumer key
     * @param *string     $secret      consumer secret
     * @param *string     $token       token
     * @param *string     $tokenSecret token secret
     * @param array       $query       extra query
     * @param string|null $realm       realm
     * @param string|null $verifier    verifier
     *
     * @return string access token
     */
    public function getPlainPostAuthorizationAccessToken(
        $url,
        $key,
        $secret,
        $token,
        $tokenSecret,
        array $query = array(),
        $realm = null,
        $verifier = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 4 must be a string
            ->test(4, 'string')
            //Argument 5 must be a string
            ->test(5, 'string')
            //Argument 7 must be a string or null
            ->test(7, 'string', 'null')
            //Argument 8 must be a string or null
            ->test(8, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to post
            ->setMethodToPost()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //when there is a verifier
            })->when($verifier, function ($instance) use ($verifier) {
                //set the verifier
                $instance->setVerifier($verifier);
            //set the request token
            })->setRequestToken($token, $tokenSecret)
            //get the token
            ->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * POST, PLAINTEXT, use Authorization Header
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getPlainPostAuthorizationRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //use authorization header
            ->useAuthorization()
            //set method to post
            ->setMethodToPost()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
    
    /**
     * Returns a request token given the requiremets
     * POST, PLAINTEXT
     *
     * @param *string     $url    url
     * @param *string     $key    consumer key
     * @param *string     $secret consumer secret
     * @param array       $query  extra query
     * @param string|null $realm  realm
     *
     * @return string request token
     */
    public function getPlainPostRequestToken(
        $url,
        $key,
        $secret,
        array $query = array(),
        $realm = null
    ) {
        //argument test
        Argument::i()
            //Argument 1 must be a string
            ->test(1, 'string')
            //Argument 2 must be a string
            ->test(2, 'string')
            //Argument 3 must be a string
            ->test(3, 'string')
            //Argument 5 must be a string or null
            ->test(5, 'string', 'null');
            
        return $this->consumer($url, $key, $secret)
            //set method to post
            ->setMethodToPost()
            //set method to PLAIN TEXT
            ->setSignatureToPlainText()
            //when there is a realm
            ->when($realm, function ($instance) use ($realm) {
                //set the realm
                $instance->setRealm($realm);
            //get the token
            })->getToken($query);
    }
}
