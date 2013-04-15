<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_FileTest extends \PHPUnit_Framework_TestCase
{
    public function testIsFile() 
    {
        $this->assertFalse(eden('utility')->file(__DIR__.'/foobar')->isFile());
        $this->assertTrue(eden('utility')->file(__FILE__)->isFile());
    }

    public function testGetBase() 
    {
        $this->assertEquals('FileTest', eden('utility')->file(__FILE__)->getBase());
    }

    public function testGetContent() 
    {
        $content = eden('utility')->file(__DIR__.'/../../../assets/test.txt')->getContent();
        $this->assertEquals('test', $content);
    }

    public function testGetData() 
    {
        $data = eden('utility')->file(__DIR__.'/../../../assets/tagalog.php')->getData();
        $this->assertArrayHasKey('How are you?', $data);
    }

    public function testGetExtension() 
    {
        $this->assertEquals('php', eden('utility')->file(__FILE__)->getExtension());
    }

    public function testGetFolder() 
    {
        $this->assertEquals(__DIR__, eden('utility')->file(__FILE__)->getFolder());
    }

    public function testGetMime() 
    {
        $mime = eden('utility')->file(__DIR__.'/../../../assets/stars.gif')->getMime();
        $this->assertEquals('image/gif', $mime);
    }

    public function testGetName() 
    {
        $this->assertEquals('FileTest.php', eden('utility')->file(__FILE__)->getName());
    }

    public function testGetSize() 
    {
        $this->assertTrue(is_int(eden('utility')->file(__FILE__)->getSize()));
    }

    public function testGetTime() 
    {
        $this->assertTrue(is_int(eden('utility')->file(__FILE__)->getTime()));
    }

    public function testSetContent() 
    {
        eden('utility')
            ->file(__DIR__.'/../../../assets/content.txt')
            ->setContent('test2');

        $content = eden('utility')
            ->file(__DIR__.'/../../../assets/content.txt')
            ->getContent();

        $this->assertEquals('test2', $content);
    }

    public function testSetData() 
    {
        $data = array('foo' => 'bar');
        eden('utility')
            ->file(__DIR__.'/../../../assets/data.php')
            ->setData($data);

        $data = eden('utility')
            ->file(__DIR__.'/../../../assets/data.php')
            ->getData();

        $this->assertArrayHasKey('foo', $data);
    }

    public function testRemove() 
    {
        $class = eden('utility')
            ->file(__DIR__.'/../../../assets/data.php')
            ->remove();

        $this->assertInstanceOf('Eden\\Utility\\File', $class);

        $this->assertFalse(file_exists(__DIR__.'/../../../assets/data.php'));

        $class = eden('utility')
            ->file(__DIR__.'/../../../assets/content.txt')
            ->remove();

        $this->assertFalse(file_exists(__DIR__.'/../../../assets/content.txt'));
    }

    public function touch() 
    {
        $class = eden('utility')
            ->file(__DIR__.'/../../../assets/content.txt')
            ->touch();

        $this->assertInstanceOf('Eden\\Utility\\File', $class);

        $this->assertTrue(file_exists(__DIR__.'/../../../assets/content.txt'));

        eden('utility')
            ->file(__DIR__.'/../../../assets/content.txt')
            ->remove();
    }
}