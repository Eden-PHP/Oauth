<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility\Timezone;

use Eden\Utility\Base;
 
/**
 * Timezone Validation
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Validation extends Base 
{
	const INSTANCE = 1;
	
    /**
	 * Validates that value is a proper abbreviation
	 *
	 * @param scalar
	 * @return bool
	 */
	public function isAbbr($value) 
	{
		//argument 1 must be scalar
		Argument::i()->test(1, 'scalar');
		
		return preg_match('/^[A-Z]{1,5}$/', $value); 
	}
	
    /**
	 * Validates that value is a proper location
	 *
	 * @param scalar
	 * @return bool
	 */
	public function isLocation($value) 
	{
		//argument 1 must be scalar
		Argument::i()->test(1, 'scalar');
		
		return in_array($value, \DateTimeZone::listIdentifiers());
	}
	
    /**
	 * Validates that value is a proper UTC
	 *
	 * @param scalar
	 * @return bool
	 */
	public function isUtc($value) 
	{
		//argument 1 must be scalar
		Argument::i()->test(1, 'scalar');
		
		return preg_match('/^(GMT|UTC){0,1}(\-|\+)[0-9]{1,2}(\:{0,1}[0-9]{2}){0,1}$/', $value); 
	}
}