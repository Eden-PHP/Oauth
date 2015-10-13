<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
class EdenOauthOauth2DesktopTest extends PHPUnit_Framework_TestCase 
{
    public function testGetLoginUrl() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';
        $encodedUrl = urlencode($url);

        $response = eden('oauth')
			->v2()
			->desktop($clientId, 'www.google.com', $url, $url, $url)
			->getLoginUrl();

        $this->assertEquals($url . '?response_type=code' .
                '&client_id=' . $clientId .
                '&redirect_uri=' . $encodedUrl, $response);
    }

    public function testGetAccess() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';

        $response = eden('oauth')
			->v2()
			->desktop($clientId, 'www.google.com', $url, $url, $url)
			->getAccess('codeless');

        $this->assertNotEmpty($response);
    }

}