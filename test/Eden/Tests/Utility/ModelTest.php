<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_ModelTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayAccess() 
    {
		$model = eden('utility')->model();
		$model->setName('Chris');
		$model['age'] = 31;
		
		$this->assertEquals('{"name":"Chris","age":31}', (string) $model);
		$this->assertEquals('Chris', $model['name']);
		$this->assertEquals(31, $model->getAge());
    }
	
	public function testIterator() 
	{
		$model = eden('utility')->model();
		$model->setName('Chris');
		$model['age'] = 31;
		
		foreach($model as $key => $value) {
			$this->assertEquals($model[$key], $value);
		}
	}
}