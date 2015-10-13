<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
class EdenOauthOauth2IndexTest extends PHPUnit_Framework_TestCase 
{
    public function testClient() 
	{
        $class = eden('oauth')
			->v2()
			->client(
				'12345', 
				'www.google.com', 
				'http://www.google.com', 
				'http://www.google.com', 
				'http://www.google.com');

        $this->assertInstanceOf('Eden\\Oauth\\Oauth2\\Client', $class);
    }

    public function testDesktop() 
	{
        $class = eden('oauth')
			->v2()
			->desktop(
				'12345', 
				'www.google.com', 
				'http://www.google.com', 
				'http://www.google.com', 
				'http://www.google.com');

        $this->assertInstanceOf('Eden\\Oauth\\Oauth2\\Desktop', $class);
    }
}
