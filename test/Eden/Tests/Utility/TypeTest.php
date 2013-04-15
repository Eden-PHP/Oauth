<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
class Eden_Tests_Utility_TypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetArray()
    {
        $class = eden('utility')->type()->getArray(array('some data'));
        $this->assertInstanceOf('Eden\\Utility\\Type\\ArrayType', $class);
    }

    public function testGetString()
    {
        $class = eden('utility')->type()->getString('some data');
        $this->assertInstanceOf('Eden\\Utility\\Type\\StringType', $class);
    }
}