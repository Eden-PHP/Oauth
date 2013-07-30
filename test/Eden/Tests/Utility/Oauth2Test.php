<?php

//-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_Oauth2Test extends \PHPUnit_Framework_TestCase {

    public function testClient() {
        $class = eden('utility')
                ->oauth2()
                ->client('12345', 'www.google.com', 'http://www.google.com', 'http://www.google.com', 'http://www.google.com');

        $this->assertInstanceOf('Eden\\Utility\\Oauth2\\Client', $class);
    }

    public function testDesktop() {
        $class = eden('utility')
                ->oauth2()
                ->desktop('12345', 'www.google.com', 'http://www.google.com', 'http://www.google.com', 'http://www.google.com');

        $this->assertInstanceOf('Eden\\Utility\\Oauth2\\Desktop', $class);
    }

}
