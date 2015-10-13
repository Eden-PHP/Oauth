<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\Oauth;

/**
 * Factory Class
 *
 * @vendor   Eden
 * @package  Core
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
     * Returns the oauth class
     *
     * @return Eden\Oauth\Oauth1
     */
    public function v1()
    {
        return Oauth1\Index::i();
    }
        
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Oauth\Oauth2
     */
    public function v2()
    {
        return Oauth2\Index::i();
    }
}
