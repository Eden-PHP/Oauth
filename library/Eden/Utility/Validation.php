<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

/**
 * Validation
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Validation extends Base 
{
	protected $value = null;
	
	/**
	 * Sets the value to be validated
	 *
	 * @param mixed
	 * @return void
	 */
	public function __construct($value) 
	{	
		$this->value = $value;
	}
	
	/**
	 * Returns true if the value is a given type
	 * 
	 * @param string
	 * @param bool
	 */
	public function isType($type) 
	{
		//argument 1 must be a string
		Argument::i()->test(1, 'string');
		
		switch($type) {
			case 'number':
				return is_numeric($this->value);
			case 'integer':
			case 'int':
				return is_numeric($this->value) && strpos((string) $this->value, '.') === false;
			case 'float':
				return is_numeric($this->value) && strpos((string) $this->value, '.') !== false;
			case 'file':
				return is_string($this->value) && file_exists($this->value);
			case 'folder':
				return is_string($this->value) && is_dir($this->value);
			case 'email':
				return is_string($this->value) && $this->isEmail($this->value);
			case 'url':
				return is_string($this->value) && $this->isUrl($this->value);
			case 'html':
				return is_string($this->value) && $this->isHtml($this->value);
			case 'creditcard':
			case 'cc':
				return (is_string($this->value) || is_int($this->value)) && $this->isCreditCard($this->value);
			case 'hex':
				return is_string($this->value) && $this->isHex($this->value);
			case 'slug':
			case 'shortname':
			case 'short':
				return !!preg_match("/^[a-z0-9-_]+$/", $this->value);
			default: break;
		}
		
		$method = 'is_'.$type;
		if(function_exists($method)) {
			return $method($this->value);
		}
		
		if(class_exists($type)) {
			return $this->value instanceof $type;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the value is greater than the passed argument
	 *
	 * @param number
	 * @return bool
	 */
	public function greaterThan($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return $this->value > (float)$number;
	}
	
	/**
	 * Returns true if the value is greater or 
	 * equal to than the passed argument
	 *
	 * @param number
	 * @return bool
	 */
	public function greaterThanEqualTo($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return $this->value >= (float)$number;
	}
	
	/**
	 * Returns true if the value is less than the passed argument
	 *
	 * @param number
	 * @return bool
	 */
	public function lessThan($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return $this->value < (float)$number;
	}
	
	/**
	 * Returns true if the value is less than 
	 * or equal the passed argument
	 *
	 * @param number
	 * @return bool
	 */
	public function lessThanEqualTo($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return $this->value <= (float)$number;
	}
	
	/**
	 * Returns true if the value length is greater than the passed argument
	 *
	 * @param number
	 * @return bool
	 */		
	public function lengthGreaterThan($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return strlen((string)$this->value) > (float)$number;
	}
	
	/**
	 * Returns true if the value length is greater 
	 * than or equal to the passed argument
	 *
	 * @param number
	 * @return bool
	 */	
	public function lengthGreaterThanEqualTo($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return strlen((string)$this->value) >= (float)$number;
	}
	
	/**
	 * Returns true if the value length is less than the passed argument
	 *
	 * @param number
	 * @return bool
	 */	
	public function lengthLessThan($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return strlen((string)$this->value) < (float)$number;
	}
	
	/**
	 * Returns true if the value length is less 
	 * than or equal to the passed argument
	 *
	 * @param number
	 * @return bool
	 */	
	public function lengthLessThanEqualTo($number) 
	{
		//argument 1 must be numeric
		Argument::i()->test(1, 'numeric');
		
		return strlen((string)$this->value) <= (float)$number;
	}
	
	/**
	 * Returns true if the value is not empty
	 *
	 * @return bool
	 */	
	public function notEmpty() 
	{
		return !empty($this->value);
	}
	
	/**
	 * Returns true if the value starts with a specific letter
	 *
	 * @return bool
	 */	
	public function startsWithLetter() 
	{
		return !!preg_match("/^[a-zA-Z]/i", $this->value);
	}
	
	/**
	 * Returns true if the value is alpha numeric
	 *
	 * @return bool
	 */	
	public function alphaNumeric() 
	{
		return !!preg_match('/^[a-zA-Z0-9]+$/', (string) $this->value);
	}
	
	/**
	 * Returns true if the value is alpha numeric underscore
	 *
	 * @return bool
	 */	
	public function alphaNumericUnderScore() 
	{
		return !!preg_match('/^[a-zA-Z0-9_]+$/', (string) $this->value);
	}
	
	/**
	 * Returns true if the value is alpha numeric hyphen
	 *
	 * @return bool
	 */	
	public function alphaNumericHyphen() 
	{
		return !!preg_match('/^[a-zA-Z0-9-]+$/', (string) $this->value);
	}
	
	/**
	 * Returns true if the value is alpha numeric hyphen or underscore
	 *
	 * @return bool
	 */	
	public function alphaNumericLine() 
	{
		return !!preg_match('/^[a-zA-Z0-9-_]+$/', (string) $this->value);
	}
	
	/**
	 * Returns true if the value is a credit card
	 *
	 * @param scalar
	 * @return bool
	 */
	protected function isCreditCard($value) 
	{
		return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]'.
		'{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-'.
		'5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $value);
	} 
	
	/**
	 * Returns true if the value is an email
	 *
	 * @param scalar
	 * @return bool
	 */
	protected function isEmail($value) 
	{
		return preg_match('/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]'.
		'\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]'.
		'\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62'.
		'}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|'.
		'[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})'.
		'(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]'.
		'+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25'.
		'[0-5])){3}\])$/', $value);
	}
	
	/**
	 * Returns true if the value is HTML
	 *
	 * @param scalar
	 * @return bool
	 */
	protected function isHtml($value) 
	{
		return preg_match("/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*".
		"(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $value);
	}
	
	/**
	 * Returns true if the value is a URL
	 *
	 * @param scalar
	 * @return bool
	 */
	protected function isUrl($value) 
	{
		return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0'.
		'-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $value);
	}
	
	/**
	 * Returns true if the value is a hex
	 *
	 * @param scalar
	 * @return bool
	 */
	protected function isHex($value) 
	{
		return preg_match("/^[0-9a-fA-F]{6}$/", $value);
	}
}