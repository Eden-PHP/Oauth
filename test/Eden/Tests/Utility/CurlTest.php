<?php

//-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_CurlTest extends \PHPUnit_Framework_TestCase {

    public function testGetDomDocumentResponse() {
//        $response = eden('utility')
//                ->curl()
//                ->setUrl('https://java-use-examples.googlecode.com/svn/trunk/pom.xml')
//                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
//                ->setConnectTimeout(10)
//                ->setFollowLocation(true)
//                ->setTimeout(60)
//                ->verifyPeer(false)
//                ->getDomDocumentResponse();
//        print_r($response);
    }

    public function testGetJsonResponse() {
        $response = eden('utility')
                ->curl()
                ->setUrl('https://graph.facebook.com/shaverm/picture?redirect=false')
//                ->setUrl('https://api.twitter.com/1.1/search/tweets.json?q=%23freebandnames&since_id=24012619984051000&max_id=250126199840518145&result_type=mixed&count=4')
                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
                ->setConnectTimeout(10)
                ->setFollowLocation(true)
                ->setTimeout(60)
                ->verifyPeer(false)
                ->getJsonResponse();
        $this->assertArrayHasKey('data', $response);
    }

    public function testGetMeta() {
        $class = eden('utility')
                ->curl()
                ->setUrl('www.google.com')
                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
                ->setConnectTimeout(10)
                ->setFollowLocation(true)
                ->setTimeout(60)
                ->verifyPeer(false);
        $response = $class->getResponse();
        $this->assertFalse(!$response);
        $this->assertArrayHasKey('info', $class->getMeta());
        $this->assertArrayHasKey('error_message', $class->getMeta());
        $this->assertArrayHasKey('error_code', $class->getMeta());
    }

    public function testGetQueryResponse() {
        $response = eden('utility')
                ->curl()
                ->setUrl('www.google.com')
                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
                ->setConnectTimeout(10)
                ->setFollowLocation(true)
                ->setTimeout(60)
                ->verifyPeer(false)
                ->getQueryResponse();
        $this->assertFalse(!$response);
    }

    public function testGetResponse() {
        $response = eden('utility')
                ->curl()
                ->setUrl('www.google.com')
                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
                ->setConnectTimeout(10)
                ->setFollowLocation(true)
                ->setTimeout(60)
                ->verifyPeer(false)
                ->getResponse();
        $this->assertFalse(!$response);
    }

    public function testGetSimpleXmlResponse() {
        $response = eden('utility')
                ->curl()
                ->setUrl('https://java-use-examples.googlecode.com/svn/trunk/pom.xml')
                ->setUserAgent('Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13')
                ->setConnectTimeout(10)
                ->setFollowLocation(true)
                ->setTimeout(60)
                ->verifyPeer(false)
                ->getSimpleXmlResponse();
        $this->assertFalse(!$response);
    }

    public function testSend() {
        $class = eden('utility')->curl()->send(array());
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testGetCustomGet() {
        $class = eden('utility')
                ->curl()
                ->setCustomGet();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testGetCustomPost() {
        $class = eden('utility')
                ->curl()
                ->setCustomPost();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testGetCustomPut() {
        $class = eden('utility')
                ->curl()
                ->setCustomPut();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testGetCustomDelete() {
        $class = eden('utility')
                ->curl()
                ->setCustomDelete();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testSetPostFields() {
        $class = eden('utility')->curl()->setPostFields(array());
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testSetHeaders() {
        
    }

    public function testSetUrlParameter() {
        
    }

    public function testVerifyHost() {
        $class = eden('utility')
                ->curl()
                ->verifyHost();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

    public function testVerifyPeer() {
        $class = eden('utility')
                ->curl()
                ->verifyPeer();
        $this->assertInstanceOf('Eden\\Utility\\Curl', $class);
    }

}