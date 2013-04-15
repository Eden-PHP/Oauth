<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
namespace Eden\Utility;

include_once __DIR__.'/../../../assets/test/session.php';

class Eden_Tests_Utility_SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testClear()
    {
        $data   = array('name' => 'juan', 'surname' => 'dela cruz');
        $class  = eden('utility')->session()->start()->set($data)->clear();
        $this->assertInstanceOf('Eden\\Utility\\Session', $class);
        $this->assertEmpty($class->get());
    }

    public function testGet()
    {
        $data   = array('name' => 'juan', 'surname' => 'dela cruz');
        $class  = eden('utility')->session()->start()->set($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $class->get($key));
        }
    }

    public function testGetId()
    {
        $class  = eden('utility')->session()->start();
        $this->assertEquals(session_id(), $class->getId());
    }

    public function testRemove()
    {
        $data   = array('name' => 'juan', 'surname' => 'dela cruz');
        $class  = eden('utility')->session()->start()->set($data)->remove('name');
        $this->assertInstanceOf('Eden\\Utility\\Session', $class);
        $this->assertArrayNotHasKey('name', $class->get());
    }

    public function testSet()
    {
        $data   = array('name' => 'juan', 'surname' => 'dela cruz');
        $class  = eden('utility')->session()->start()->set($data);
        $this->assertInstanceOf('Eden\\Utility\\Session', $class);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $class->get($key));
        }
    }

    public function testSetId()
    {
        $sessionId  = eden('utility')->session()->start()->setId(12);
        $this->assertEquals(12, $sessionId);
    }

    public function testStart()
    {
        $class  = eden('utility')->session()->start();
        $this->assertInstanceOf('Eden\\Utility\\Session', $class);
    }

    public function testStop()
    {
        $class  = eden('utility')->session()->stop();
        $this->assertInstanceOf('Eden\\Utility\\Session', $class);
    }

    public function testArrayAccess()
    {
        $class = eden('utility')->session()->start();

        $class[] = array('name' => 'John', 'age' => 31);
        $class[] = array('name' => 'Jane', 'age' => 28);

        $this->assertFalse(isset($class[2]));

        $this->assertEquals('Jane', $class[1]['name']);
    }

    public function testIterable()
    {
        $class[]    = eden('utility')->session()->start();
        $class[]    = array('name' => 'John', 'age' => 31);
        $class[]    = array('name' => 'Jane', 'age' => 28);
        $class[]    = array('name' => 'Jack', 'age' => 35);

        foreach($class as $key => $value) {
            $this->assertEquals($class[$key]['name'], $value['name']);
        }
    }
}