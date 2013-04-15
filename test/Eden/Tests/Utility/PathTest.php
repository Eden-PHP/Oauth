<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_PathTest extends \PHPUnit_Framework_TestCase
{
	public function testAbsolute() 
    {
		try {
			eden('utility')->path('some/path/')->absolute();
		} catch(Exception $e) {
			$this->assertInstanceOf('Eden\\Utility\\Exception', $e);	
		}
		
		$class = eden('utility')->path(__FILE__)->absolute();
		$this->assertInstanceOf('Eden\\Utility\\Path', $class);
    }
	
    public function testAppend() 
    {
		$path = eden('utility')->path('some/path/')->append('foo');
		$this->assertEquals('/some/path/foo', (string) $path);
    }

    public function testGetArray() 
    {
		$array = eden('utility')->path('some/path/')->getArray();
		$this->assertTrue(in_array('some', $array));
		$this->assertTrue(in_array('path', $array));
    }

    public function testPrepend() 
    {
		$path = eden('utility')->path('some/path/')->prepend('foo');
		$this->assertEquals('/foo/some/path', (string) $path);
    }

    public function testPop()
    {
		$this->assertEquals('path', eden('utility')->path('some/path/')->pop());
    }

    public function testReplace() 
    {
		$path = eden('utility')->path('some/path/')->replace('foo');
		$this->assertEquals('/some/foo', (string) $path);
    }
	
	public function testArrayAccess() 
	{
		$path = eden('utility')->path('some/path/');
		$this->assertEquals('some', $path[1]);
		$path['replace'] = 'foo';
		$this->assertEquals('foo', $path['last']);
	}
}