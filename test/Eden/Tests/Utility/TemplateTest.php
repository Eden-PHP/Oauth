<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testSet() 
    {
		$class = eden('utility')->template()->set('foo', 'bar');
		$this->assertInstanceOf('Eden\\Utility\\Template', $class);
    }
	
    public function testParseString() 
    {
        $string = eden('utility')->template()->set('[SOME]', 'no')->parseString('[SOME]thing');
		$this->assertEquals('nothing', $string);
    }
	
	public function testParsePhp() 
	{
		$string = eden('utility')->template()
			->set('test', array('key' => 'something'))
			->parsePhp(__DIR__.'/../../../assets/template.php');
		
		$this->assertEquals('something', $string);
	}
}