<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_ValidationTest extends \PHPUnit_Framework_TestCase
{
    public function testIsType()
    {
        $valid = eden('utility')->validation(1)->isType('int');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('1')->isType('int');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('foo')->isType('int');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation(1.1)->isType('float');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('4.9')->isType('float');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(1)->isType('float');
        $this->assertFalse($valid);
        $valid = eden('utility')->validation('foo')->isType('float');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation('3.4')->isType('numeric');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('foo')->isType('numeric');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation('foo')->isType('string');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(1)->isType('string');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation(1)->isType('scalar');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(true)->isType('scalar');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('check')->isType('scalar');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(null)->isType('scalar');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation(true)->isType('bool');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(1)->isType('bool');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation(array(1,2,3))->isType('array');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation('not an array')->isType('array');
        $this->assertFalse($valid);
		
        $valid = eden('utility')->validation(new stdClass())->isType('object');
        $this->assertTrue($valid);
        $valid = eden('utility')->validation(1)->isType('object');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation(__FILE__)->isType('file');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('/some/path')->isType('file');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation(1)->isType('file');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation(__DIR__)->isType('folder');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('/some/path')->isType('folder');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation(1)->isType('folder');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation('james@hotmail.com')->isType('email');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('james@hot@mail.com')->isType('email');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation('jam.es@hot.mail.com')->isType('email');
        $this->assertTrue($valid);
		
		$valid = eden('utility')->validation('http://www.hotmail.com/')->isType('url');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('www.hotmail.com/')->isType('url');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation('<div>Cool</div>')->isType('html');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('Not Cool')->isType('html');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation('Not div>Cool')->isType('html');
        $this->assertFalse($valid);
		
        // Credit Card Number must treated as string not numeric value..
        // Pattern doesn't much on numeric when it exceed to 13+ length of value..
                // Visa
		$valid = eden('utility')->validation('4485945357740101')->isType('cc');
        $this->assertTrue($valid);
                // MasterCard
		$valid = eden('utility')->validation('5508760509409558')->isType('cc');
        $this->assertTrue($valid);
                // AMEX
		$valid = eden('utility')->validation('340539457582696')->isType('cc');
        $this->assertTrue($valid);
                // Discover
		$valid = eden('utility')->validation('6011938784708070')->isType('cc');
        $this->assertTrue($valid);
                // Dinners Club
		$valid = eden('utility')->validation('36356552261053')->isType('cc');
        $this->assertTrue($valid);
        
		$valid = eden('utility')->validation('1230495')->isType('cc');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation('Foo')->isType('cc');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation('567ABC')->isType('hex');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('19JK34')->isType('hex');
        $this->assertFalse($valid);
		
		$valid = eden('utility')->validation('some-short-title')->isType('slug');
        $this->assertTrue($valid);
		$valid = eden('utility')->validation('some-Short-title')->isType('slug');
        $this->assertFalse($valid);
		$valid = eden('utility')->validation('some short-title')->isType('slug');
        $this->assertFalse($valid);
    }
	
	public function testGreaterThan() 
	{
        $valid = eden('utility')->validation(10)->greaterThan(5);
        $this->assertTrue($valid);
	}
	
	public function testGreaterThanEqualTo() 
	{
        $valid = eden('utility')->validation(10)->greaterThanEqualTo(10);
        $this->assertTrue($valid);
	}
	
	public function testLessThan() 
	{
        $valid = eden('utility')->validation(10)->lessThan(5);
        $this->assertFalse($valid);
	}
	
	public function testLessThanEqualTo() 
	{
        $valid = eden('utility')->validation(10)->lessThanEqualTo(10);
        $this->assertTrue($valid);
	}
		
	public function testLengthGreaterThan() 
	{
        $valid = eden('utility')->validation('Something')->lengthGreaterThan(5);
        $this->assertTrue($valid);
	}
	
	public function testLengthGreaterThanEqualTo() 
	{
        $valid = eden('utility')->validation('Something')->lengthGreaterThanEqualTo(9);
        $this->assertTrue($valid);
	}
		
	public function testLengthLessThan() 
	{
        $valid = eden('utility')->validation('Something')->lengthLessThan(5);
        $this->assertFalse($valid);
	}
	
	public function testLengthLessThanEqualTo() 
	{
        $valid = eden('utility')->validation('Something')->lengthLessThanEqualTo(9);
        $this->assertTrue($valid);
	}
	
	public function testNotEmpty() 
	{
        $valid = eden('utility')->validation('Something')->notEmpty();
        $this->assertTrue($valid);
	}
	
	public function testStartsWithLetter() 
	{
        $valid = eden('utility')->validation('9Something')->startsWithLetter();
        $this->assertFalse($valid);
	}
	
	public function testAlphaNumeric() 
	{
		$valid = eden('utility')->validation('9Something')->alphaNumeric();
        $this->assertTrue($valid);
		
		$valid = eden('utility')->validation('9 Something')->alphaNumeric();
        $this->assertFalse($valid);
	}
	
	public function testAlphaNumericUnderScore() 
	{
		$valid = eden('utility')->validation('9_Something')->alphaNumericUnderScore();
        $this->assertTrue($valid);
		
		$valid = eden('utility')->validation('9 Something')->alphaNumericUnderScore();
        $this->assertFalse($valid);
	}
	
	public function testAlphaNumericHyphen() 
	{
		$valid = eden('utility')->validation('9-Something')->alphaNumericHyphen();
        $this->assertTrue($valid);
		
		$valid = eden('utility')->validation('9_Something')->alphaNumericHyphen();
        $this->assertFalse($valid);
	}
	
	public function testAlphaNumericLine() 
	{
		$valid = eden('utility')->validation('9_Someth-ing')->alphaNumericLine();
        $this->assertTrue($valid);
		
		$valid = eden('utility')->validation('9 Some-th_ing')->alphaNumericLine();
        $this->assertFalse($valid);
	}
}