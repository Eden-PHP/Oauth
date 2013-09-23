<?php //--> 
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Oauth\Oauth2;

/**
 * Oauth2 server methods
 *
 * @vendor Eden
 * @package Oauth
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Server extends Base 
{
	/**
	 * Generates an unique token.
	 *
	 * @return string
	 */
	public function generateToken() 
	{
		$random = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);
		return substr(hash('sha512', $random), 0, 40);
	}
}