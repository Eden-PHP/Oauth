<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 402543059d9fcbf33d83a439e7936ca297576458
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
     * @return Eden\Oauth\Oauth
     */
    public function oauth()
    {
        return Oauth::i();
    }
		
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Oauth\Oauth2
     */
    public function oauth2()
    {
        return Oauth2::i();
    }
<<<<<<< HEAD
=======
=======
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
     * Returns the cURL class
     *
     * @return Eden\Utility\Curl
     */
    public function curl()
    {
        return Curl::i();
    }
	
    /**
     * Returns the oauth class
     *
     * @return Eden\Oauth\Oauth
     */
    public function oauth()
    {
        return Oauth::i();
    }
		
    /**
     * Returns the oauth2 class
     *
     * @return Eden\Oauth\Oauth2
     */
    public function oauth2()
    {
        return Oauth2::i();
    }
>>>>>>> e7c7a60f61a44dfffc40cf69a2c30337d5ce2131
>>>>>>> 402543059d9fcbf33d83a439e7936ca297576458
}