<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth2;

use Eden\Oauth\Argument;
use Eden\Oauth\Exception;
use Eden\Curl\Index as Curl;

/**
 * Oauth2 abstract class
 *
 * @vendor   Eden
 * @package  Oauth
 * @author   Christian Symon M. Buenavista sbuenavista@openovate.com
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
abstract class Base extends \Eden\Oauth\Base
{
    /**
     * @const string CODE URL code name
     */
    const CODE = 'code';
       
    /**
     * @const string TOKEN URL token name
     */
    const TOKEN = 'token';
       
    /**
     * @const string ONLINE Access type value
     */
    const ONLINE = 'online';
       
    /**
     * @const string OFFLINE Access type value
     */
    const OFFLINE = 'offline';
       
    /**
     * @const string AUTO Approval setting
     */
    const AUTO = 'auto';
       
    /**
     * @const string FORCE Approval setting
     */
    const FORCE = 'force';
       
    /**
     * @const string TYPE Header key
     */
    const TYPE = 'Content-Type';
       
    /**
     * @const string REQUEST Post encoding
     */
    const REQUEST = 'application/x-www-form-urlencoded';
       
    /**
     * @var string|null $client Client ID token
     */
    protected $client = null;
       
    /**
     * @var array $meta Any saved meta data post request
     */
    protected $meta = array();
       
    /**
     * @var string|null $secret Client hash token
     */
    protected $secret = null;
       
    /**
     * @var string|null $redirect Where to redirect to
     */
    protected $redirect = null;
       
    /**
     * @var string|null $state An arbitrary unique string for anti request forgery
     */
    protected $state = null;
       
    /**
     * @var string|null $scope The permissions needed from the app
     */
    protected $scope = null;
       
    /**
     * @var string|null $display The login display type to use
     */
    protected $display  = null;
       
    /**
     * @var string|null $requestUrl The login URL
     */
    protected $requestUrl = null;
       
    /**
     * @var string|null $accessUrl The REST URL to exchange the code to access token
     */
    protected $accessUrl = null;
       
    /**
     * @var string $responseType The response type to give back
     */
    protected $responseType = self::CODE;
       
    /**
     * @var string $approvalPrompt The type of approval prompt
     */
    protected $approvalPrompt = self::AUTO;

    /**
     * Preset some tokens we need
     *
     * @param *string $client     The application client ID, can get through registration
     * @param *string $secret     The application secret, can get through registration
     * @param *string $redirect   Your callback url or where do you want to redirect the user after authentication
     * @param *string $requestUrl The request url,  can get through registration
     * @param *string $accessUrl  The access url,  can get through registration
     *
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
     * @param *string $state The state value to set
     *
     * @return Eden\Oauth\Oauth2\Base
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
     * @param *string|array $scope List of scopes
     *
     * @return Eden\Oauth\Oauth2\Base
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
     * @param *string|array $display Display value
     *
     * @return Eden\Oauth\Oauth2\Base
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
     * @param *string $string The string to test
     *
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
     * Abstract function for getting login url
     *
     * @param string|null $scope   List of scopes
     * @param string|null $display The display type
     *
     * @return string
     */
    abstract public function getLoginUrl($scope = null, $display = null);

    /**
     * Returns website login url
     *
     * @param string* $code Usually from the URL after redirected back
     *
     * @return array
     */
    abstract public function getAccess($code);

    /**
     * Generates a login url to redirect to
     *
     * @param *string $query Query string to include in the URL
     *
     * @return string
     */
    protected function generateLoginUrl($query)
    {
        //if there is a scope
        if (!is_null($this->scope)) {
            //if scope is in array
            if (is_array($this->scope)) {
                $this->scope = implode(' ', $this->scope);
            }
            //add scope to the query
            $query['scope'] = $this->scope;
        }
        //if there is state
        if (!is_null($this->state)) {
            //add state to the query
            $query['state'] = $this->state;
        }
        //if there is display
        if (!is_null($this->display)) {
            //add state to the query
            $query['display'] = $this->display;
        }
        //generate a login url
        return $this->requestUrl.'?'.http_build_query($query);
    }

    /**
     * Returns an access token from server
     *
     * @param *string     $query        Query string to include in the URL
     * @param string|null $code         Usually from the URL after redirected back
     * @param *bool       $refreshToken Whether or not we need the tokens refreshed
     *
     * @return string
     */
    protected function generateAccess($query, $code = null, $refreshToken = false)
    {
        //if there is a code
        if (!is_null($code)) {
            //if you only want to refresh a token
            if ($refreshToken) {
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

        $this->meta     = $curl->getMeta();
        $this->meta['query'] = $query;
        $this->meta['url'] = $this->accessUrl;
        $this->meta['response']     = $result;

        //check if results is in JSON format
        if ($this->isJson($result)) {
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
