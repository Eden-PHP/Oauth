<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Utility;

use Eden\Utility\Type\ArrayType;

/**
 * Base model that allows setting and getting of key values
 *
 * @vendor Eden
 * @package Utility
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Model extends ArrayType 
{
	/**
	 * We are disallowing the PHP default functions 
	 * from being called
	 * 
	 * @param string
	 * @return false
	 */
    protected function getMethodType(&$name) 
    {
        return false;
    }
}