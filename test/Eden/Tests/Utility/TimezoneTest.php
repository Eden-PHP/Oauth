<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_TimezoneTest extends \PHPUnit_Framework_TestCase
{
	public function setup() 
	{
		date_default_timezone_set('GMT');
	}
    
	public function testConvertTo() 
	{
		//zone = Asia/Manila, time = 1358756901, date = January 21, 2013 8:28AM
		//zone = America/Los_Angeles, time = ?, date = January 20, 2013 4:28PM
		
		$date = eden('utility')
			->timezone('Asia/Manila', 1358778480)
			->convertTo('America/Los_Angeles', 'F d, Y g:iA');
		
		$this->assertEquals('January 20, 2013 4:28PM', $date);
	}
	
	public function testGetGMT() 
	{
		$gmt = eden('utility')->timezone('Asia/Manila')->getGMT();
		$this->assertEquals('GMT+800', $gmt);
	}
	
	public function testGetGMTDates() 
	{
		$dates = eden('utility')->timezone('Asia/Manila')->getGMTDates('F d, Y g:iA', 60);
		$this->assertEquals(25, count($dates));
		$this->assertArrayHasKey('GMT+800', $dates);
	}
	
	public function testGetOffset() 
	{
		$offset = eden('utility')->timezone('Asia/Manila')->getOffset();
		$this->assertEquals(28800, $offset);
	}
	
	public function testGetOffsetDates() 
	{
		$dates = eden('utility')->timezone('Asia/Manila')->getOffsetDates('F d, Y g:iA', 60);
		$this->assertEquals(25, count($dates));
		$this->assertArrayHasKey('28800', $dates);
	}
	
	public function testGetTime() 
	{
		$date = eden('utility')
			->timezone('Asia/Manila', 1358756901)
			->getTime('F d, Y g:iA');
			
		$this->assertEquals('January 21, 2013 8:28AM', $date);
	}
	
	public function testGetUTC() 
	{
		$utc = eden('utility')->timezone('Asia/Manila')->getUTC();
		$this->assertEquals('UTC+8:00', $utc);
	}
	
	public function testGetUTCDates() 
	{
		$dates = eden('utility')->timezone('Asia/Manila')->getUTCDates('F d, Y g:iA', 60);
		$this->assertEquals(25, count($dates));
		$this->assertArrayHasKey('UTC+8:00', $dates);
	}
	
	public function testSetTime() 
	{
	}
	
	public function testValidation() 
	{
		$class = eden('utility')->timezone('Asia/Manila')->validation();
		$this->assertInstanceOf('Eden\\Utility\\Timezone\\Validation', $class);
	}
}