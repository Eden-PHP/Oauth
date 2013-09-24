<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Oauth;

/**
 * Core Factory Class
 *
 * @vendor Eden
 * @package Core
 * @author Christian Blanquera cblanquera@openovate.com
 */
class Factory extends Base
{
    const INSTANCE = 1;
	
    /**
     * Returns the oauth class
     *
     * @return Eden\Oauth\Oauth1
     */
    public function v1()
    {
        return Oauth1::i();
    }
		
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Oauth\Oauth2
     */
    public function v2()
    {
        return Oauth2::i();
    }
}