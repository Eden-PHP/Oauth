<?php

//-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_Timezone_ValidationTest extends \PHPUnit_Framework_TestCase {

    public function testIsAbbr() {
        $zone = 'abbr';
        $class = eden('utility')->timezone($zone)->validation();
        $this->assertInstanceOf('Eden\\Utility\\Timezone\\Validation', $class);
        $this->assertTrue((bool) $class->isAbbr('ABCDE'));
        $this->assertFalse((bool) $class->isAbbr('abcde'));
    }

    public function testIsLocation() {
        $zone = 'location';
        $class = eden('utility')->timezone($zone)->validation();
        $this->assertInstanceOf('Eden\\Utility\\Timezone\\Validation', $class);
        $this->assertTrue((bool) $class->isLocation('Asia/Manila'));
    }

    public function testIsUtc() {
        $zone = 'utc';
        $class = eden('utility')->timezone($zone)->validation();
        $this->assertInstanceOf('Eden\\Utility\\Timezone\\Validation', $class);
        $this->assertTrue((bool) $class->isUtc('GMT+8'));
        
    }

}