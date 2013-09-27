<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
namespace Eden\Oauth\Oauth1;

use Eden\Oauth\Argument;
use Eden\Curl\Base as Curl;

/**
 * Oauth consumer methods
 *
 * @vendor Eden
 * @package Oauth
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Consumer extends Base 
{
	const AUTH_HEADER = 'Authorization: OAuth %s';
	const POST_HEADER = 'Content-Type: application/x-www-form-urlencoded';
	
	protected $consumerKey = null; 
	protected $consumerSecret = null; 
	protected $requestToken = null; 
	protected $requestSecret = null; 
	protected $useAuthorization = false;
	
	protected $url	= null; 
	protected $method = null;
	protected $realm = null; 
	protected $time = null; 
	protected $nonce = null; 
	protected $verifier = null; 
	protected $callback = null;
	protected $signature = null;
	protected $meta = array();
	protected $headers	= array();
	 
	protected $json = false;
	
	/**
	 * Pre set the url key and secret
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return void
	 */
	public function __construct($url, $key, $secret) 
	{
		//argument test
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')		
			//Argument 2 must be a string
			->test(2, 'string')		
			//Argument 3 must be a string
			->test(3, 'string');	
		
		$this->consumerKey 	= $key;
		$this->consumerSecret 	= $secret;
		
		$this->url		= $url;
		$this->time 	= time();
		$this->nonce 	= md5(uniqid(rand(), true));
		
		$this->signature = self::PLAIN_TEXT;
		$this->method = self::GET;
	}
	
	/**
	 * Returns the authorization header string
	 *
	 * @param string
	 * @param bool
	 * @return string
	 */
	public function getAuthorization($signature, $string = true) 
	{
		//argument test
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')		
			//Argument 2 must be a boolean
			->test(2, 'bool');		
		
		//this is all possible configurations
		$params = array(
			'realm'	=> $this->realm,
			'oauth_consumer_key' => $this->consumerKey,
			'oauth_token' => $this->requestToken,
			'oauth_signature_method' => self::HMAC_SHA1,
			'oauth_signature' => $signature,
			'oauth_timestamp' => $this->time,
			'oauth_nonce' => $this->nonce,
			'oauth_version'	=> self::OAUTH_VERSION,
			'oauth_verifier' => $this->verifier,
			'oauth_callback' => $this->callback);
		
		//if no realm
		if(is_null($this->realm)) {
			//remove it
			unset($params['realm']);
		}
		
		//if no token
		if(is_null($this->requestToken)) {
			//remove it
			unset($params['oauth_token']);
		}
		
		//if no verifier
		if(is_null($this->verifier)) {
			//remove it
			unset($params['oauth_verifier']);
		}
		
		
		//if no callback
		if(is_null($this->callback)) {
			//remove it
			unset($params['oauth_callback']);
		}
		
		if(!$string) {
			return $params;
		}
		
		return sprintf(self::AUTH_HEADER, $this->buildQuery($params, ',', false));	
	}
	
	/**
	 * Returns the results
	 * parsed as DOMDocument
	 *
	 * @return DOMDocument
	 */
	public function getDomDocumentResponse(array $query = array()) 
	{
		$xml = new DOMDocument();
		$xml->loadXML($this->getResponse($query));
		return $xml;
	}
	
	/**
	 * Returns the signature
	 *
	 * @return string
	 */
	public function getHmacPlainTextSignature() 
	{
		return $this->consumerSecret . '&' . $this->tokenSecret;
	}
	
	/**
	 * Returns the signature
	 *
	 * @param array
	 * @return string
	 */
	public function getHmacSha1Signature(array $query = array()) 
	{
		//this is like the authorization params minus the realm and signature
		$params = array(
			'oauth_consumer_key' => $this->consumerKey,
			'oauth_token' => $this->requestToken,
			'oauth_signature_method' => self::HMAC_SHA1,
			'oauth_timestamp' => $this->time,
			'oauth_nonce' => $this->nonce,
			'oauth_version'	=> self::OAUTH_VERSION,
			'oauth_verifier' => $this->verifier,
			'oauth_callback' => $this->callback);
		
		//if no token
		if(is_null($this->requestToken)) {
			//unset that parameter
			unset($params['oauth_token']);
		}
		
		//if no token
		if(is_null($this->verifier)) {
			//unset that parameter
			unset($params['oauth_verifier']);
		}
		
		//if no callback
		if(is_null($this->callback)) {
			//remove it
			unset($params['oauth_callback']);
		}
		
		$query = array_merge($params, $query); //merge the params and the query
		$query = $this->buildQuery($query); //make query into a string
		
		//create the base string
		$string = array($this->method, $this->encode($this->url), $this->encode($query));
		$string = implode('&', $string);
		
		//create the encryption key
  		$key = $this->encode($this->consumerSecret) . '&' . $this->encode($this->requestSecret);
		
		//authentication method
		return base64_encode(hash_hmac('sha1', $string, $key, true));
	}
	
	/**
	 * Returns the json response from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getJsonResponse(array $query = array(), $assoc = true) 
	{
		//argument 2 must be bool
		Argument::i()->test(2, 'bool');
		
		return json_decode($this->getResponse($query), $assoc);
	}
	
	/**
	 * Returns the meta of the last call
	 *
	 * @param string|null
	 * @return array
	 */
	public function getMeta($key = null) 
	{
		//argument 1 must be string or null
		Argument::i()->test(1, 'string', 'null');
		
		if(isset($this->meta[$key])) {
			return $this->meta[$key];
		}
		
		return $this->meta;
	}
	
	/**
	 * Returns the query response from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getQueryResponse(array $query = array()) 
	{
		parse_str($this->getResponse($query), $response);
		return $response;
	}
	
	/**
	 * Returns the token from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getResponse(array $query = array()) 
	{
		$headers = $this->headers;
		$json = null;
		
		if($this->json) {
			$json 	= json_encode($query);
			$query 	= array();
		}
		
		//get the authorization parameters as an array
		$signature = $this->getSignature($query);
		$authorization 	= $this->getAuthorization($signature, false);
		
		//if we should use the authrization
		if($this->useAuthorization) {
			//add the string to headers
			$headers[] = sprintf(self::AUTH_HEADER, $this->buildQuery($authorization, ',', false));
		} else {
			//merge authorization and query
			$query = array_merge($authorization, $query);
		}
		
		$query = $this->buildQuery($query);
		$url = $this->url;
		
		//set curl
		$curl = Curl::i()->verifyHost(false)->verifyPeer(false);
		
		//if post
		if($this->method == self::POST) {
			$headers[] = self::POST_HEADER;
			
			if(!is_null($json)) {
				$query = $json;
			}
			
			//get the response
			$response = $curl->setUrl($url)
				->setPost(true)
				->setPostFields($query)
				->setHeaders($headers)
				->getResponse();
		} else {
			if(trim($query)) {
				//determine the conector
				$connector = null;
				
				//if there is no question mark
				if(strpos($url, '?') === false) {
					$connector = '?';
				//if the redirect doesn't end with a question mark
				} else if(substr($url, -1) != '?') {
					$connector = '&';
				}
				
				//now add the secret to the redirect
				$url .= $connector.$query;
			}
			
			//get the response
			$response = $curl->setUrl($url)->setHeaders($headers)->getResponse();
		}
		
		$this->meta = $curl->getMeta();
		$this->meta['url'] = $url;
		$this->meta['authorization'] = $authorization;
		$this->meta['headers'] = $headers;
		$this->meta['query'] = $query;
		$this->meta['response'] = $response;
		
		return $response;
	}
	
	/**
	 * Returns the signature based on what signature method was set
	 *
	 * @param array
	 * @return string
	 */
	public function getSignature(array $query = array()) 
	{
		switch($this->signature) {
			case self::HMAC_SHA1:
				return $this->getHmacSha1Signature($query);
			case self::RSA_SHA1:
			case self::PLAIN_TEXT:
			default:
				return $this->getHmacPlainTextSignature();
		}
	}
	
	/**
	 * Returns the results
	 * parsed as SimpleXml
	 *
	 * @param array
	 * @return SimpleXmlElement
	 */
	public function getSimpleXmlResponse(array $query = array()) 
	{
		return simplexml_load_string($this->getResponse($query));
	}
	
	/**
	 * When sent, sends the parameters as post fields
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function jsonEncodeQuery() 
	{
		$this->json = true;
		return $this;
	}
	
	/**
	 * Sets the callback for authorization
	 * This should be set if wanting an access token
	 *
	 * @param string
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setCallback($url) 
	{
		//argument 1 must be a string
		Argument::i()->test(1, 'string');
		
		$this->callback = $url;
		
		return $this;
	}
	
	/**
	 * Sets request headers
	 *
	 * @param array|string
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setHeaders($key, $value = null) 
	{
		Argument::i()
			//argument 1 must be an array or string
			->test(1, 'array', 'string') 
			//argument 2 must be scalar or null
			->test(2, 'scalar','null');  
		
		if(is_array($key)) {
			$this->headers = $key;
			return $this;
		}
		
		$this->headers[] = $key.': '.$value;
		return $this;
	}
	
	/**
	 * When sent, appends the parameters to the URL
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setMethodToGet() 
	{
		$this->method = self::GET;
		return $this;
	}
	
	/**
	 * When sent, sends the parameters as post fields
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setMethodToPost() 
	{
		$this->method = self::POST;
		return $this;
	}
	
	/**
	 * Some Oauth servers requires a realm to be set
	 *
	 * @param string
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setRealm($realm) 
	{
		//argument must be a string
		Argument::i()->test(1, 'string');
		
		$this->realm = $realm;
		return $this;
	}
	
	/**
	 * Sets the signature encryption type to HMAC-SHA1
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setSignatureToHmacSha1() 
	{
		$this->signature = self::HMAC_SHA1;
		return $this;
	}
	
	/** 
	 * Sets the signature encryption to RSA-SHA1
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setSignatureToRsaSha1() 
	{
		$this->signature = self::RSA_SHA1;
		return $this;
	}
	
	/** 
	 * Sets the signature encryption to PLAINTEXT
	 *
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setSignatureToPlainText() 
	{
		$this->signature = self::PLAIN_TEXT;
		return $this;
	}
	
	/**
	 * Sets the request token and secret. 
	 * This should be set if wanting an access token
	 *
	 * @param string
	 * @param string
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setToken($token, $secret) 
	{
		Argument::i()
			//argument 1 must be a string
			->test(1, 'string')  
			//argument 2 must be a string
			->test(2, 'string'); 
		
		$this->requestToken = $token;
		$this->requestSecret = $secret;
		
		return $this;
	}
	
	/**
	 * Some Oauth servers requires a verifier to be set
	 * when retrieving an access token
	 *
	 * @param string
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function setVerifier($verifier) 
	{
		//argument 1 must be scalar
		Argument::i()->test(1, 'scalar');
		
		$this->verifier = $verifier;
		return $this;
	}
	
	/**
	 * When sent, appends the authroization to the headers
	 *
	 * @param bool
	 * @return Eden\Oauth\Oauth\Consumer
	 */
	public function useAuthorization($use = true) 
	{
		//argument 1 must be a boolean
		Argument::i()->test(1, 'bool');
		
		$this->useAuthorization = $use;
		return $this;
	}
}