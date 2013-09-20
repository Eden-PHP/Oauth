<?php
namespace Eden\Oauth;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 08:38:01.
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCurl()
    {
        $class = eden('oauth')->curl();
        $this->assertInstanceOf('Eden\\Oauth\\Curl', $class);
    }

    public function testOauth()
    {
		$class = eden('oauth')->oauth();
		$this->assertInstanceOf('Eden\\Oauth\\Oauth', $class);
    }

    public function testOauth2()
    {
		$class = eden('oauth')->oauth2();
		$this->assertInstanceOf('Eden\\Oauth\\Oauth2', $class);
    }

}
