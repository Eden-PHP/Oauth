<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
class EdenOauthOauth2ClientTest extends PHPUnit_Framework_TestCase 
{

    public function testForOffline() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';

        $class = eden('oauth')
                ->v2()
                ->client($clientId, 'www.google.com', $url, $url, $url)
                ->forOffline();

        $this->assertInstanceOf('Eden\\Oauth\\Oauth2\\Client', $class);
        $this->assertContains('access_type=offline', $class->getLoginUrl());
    }

    public function testForOnline() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';

        $class = eden('oauth')
                ->v2()
                ->client($clientId, 'www.google.com', $url, $url, $url)
                ->forOnline();

        $this->assertInstanceOf('Eden\\Oauth\\Oauth2\\Client', $class);
        $this->assertContains('access_type=online', $class->getLoginUrl());
    }

    public function testApprovalPromptToAuto() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';

        $class = eden('oauth')
                ->v2()
                ->client($clientId, 'www.google.com', $url, $url, $url)
                ->approvalPromptToAuto();

        $this->assertInstanceOf('Eden\\Oauth\\Oauth2\\Client', $class);
        $this->assertContains('approval_prompt=auto', $class->getLoginUrl());
    }

    public function testGetLoginUrl() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';
        $encodedUrl = urlencode($url);

        $response = eden('oauth')
                ->v2()
                ->client($clientId, 'www.google.com', $url, $url, $url)
                ->forOnline()
                ->approvalPromptToAuto()
                ->getLoginUrl();

        $this->assertEquals($url . '?response_type=code' .
                '&client_id=' . $clientId .
                '&redirect_uri=' . $encodedUrl .
                '&access_type=online' .
                '&approval_prompt=auto', $response);
    }

    public function testGetAccess() 
	{
        $clientId = '12345';
        $url = 'http://www.google.com';

        $response = eden('oauth')
                ->v2()
                ->client($clientId, 'www.google.com', $url, $url, $url)
                ->forOnline()
                ->approvalPromptToAuto()
                ->getAccess('codeless');

        $this->assertNotEmpty($response);
    }

}
