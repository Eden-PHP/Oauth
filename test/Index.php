<?php
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
class EdenOauthIndexTest extends PHPUnit_Framework_TestCase
{
    public function testV1()
    {
		$class = eden('oauth')->v1();
		$this->assertInstanceOf('Eden\\Oauth\\Oauth1', $class);
    }

    public function testV2()
    {
		$class = eden('oauth')->v2();
		$this->assertInstanceOf('Eden\\Oauth\\Oauth2', $class);
    }

}