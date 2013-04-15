<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_Type_StringTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelize()
    {
        $string         = 'test-value';
        $resultString   = 'testValue';
        $class = eden('utility')->type($string)->camelize('-');
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
        $newString = $class->get();
        $this->assertEquals($resultString, $newString);
    }

    public function testDasherize()
    {
        $string         = 'test Value';
        $resultString   = 'test-value';
        $class = eden('utility')->type($string)->dasherize();
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
        $newString = $class->get();
        $this->assertEquals($resultString, $newString);
    }

    public function testSummarize()
    {
        $string         = 'the quick brown fox jumps over the lazy dog';
        $resultString   = 'the quick';
        $class = eden('utility')->type($string)->summarize(3);
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
        $newString = $class->get();
        $this->assertEquals($resultString, $newString);
    }

    public function testTitlize()
    {
        $string         = 'test+Value';
        $resultString   = 'Test Value';
        $class = eden('utility')->type($string)->titlize('+');
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
        $newString = $class->get();
        $this->assertEquals($resultString, $newString);
    }

    public function testUncamelize()
    {
        $string         = 'testValue';
        $resultString   = 'test-value';
        $class = eden('utility')->type($string)->uncamelize('-');
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
        $newString = $class->get();
        $this->assertEquals($resultString, $newString);
    }
}