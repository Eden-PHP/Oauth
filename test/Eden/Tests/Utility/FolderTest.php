<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

class Eden_Tests_Utility_FolderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate() 
    {
        $class = eden('utility')->folder(__DIR__.'/../../../assets/foobar')->create(0777);
        $this->assertInstanceOf('Eden\\Utility\\Folder', $class);

        $this->assertTrue(file_exists(__DIR__.'/../../../assets/foobar'));
    }

    public function testGetFiles() 
    {
        $files = eden('utility')->folder(__DIR__.'/../../../assets')->getFiles();
        $this->assertEquals(4, count($files));

        $files = eden('utility')->folder(__DIR__.'/../../../assets')->getFiles('/.*\.php$/');
        $this->assertEquals(2, count($files));


        $files = eden('utility')->folder(__DIR__.'/../../../assets')->getFiles(null, true);
        $this->assertEquals(8, count($files));


        $files = eden('utility')->folder(__DIR__.'/../../../assets')->getFiles('/.*\.php$/', true);
        $this->assertEquals(4, count($files));
    }

    public function testGetFolders() 
    {
        $folders = eden('utility')->folder(__DIR__.'/../../../assets')->getFolders();
        $this->assertEquals(2, count($folders));

        $folders = eden('utility')->folder(__DIR__.'/../../../assets')->getFolders('/^foo/');
        $this->assertEquals(1, count($folders));

        $folders = eden('utility')->folder(__DIR__.'/../../../assets')->getFolders(null, true);
        $this->assertEquals(2, count($folders));

        $folders = eden('utility')->folder(__DIR__.'/../../../assets')->getFolders('/^test/', true);
        $this->assertEquals(1, count($folders));
    }

    public function testGetName() 
    {
        $name = eden('utility')->folder(__DIR__.'/../../../assets')->getName();
        $this->assertEquals('assets', $name);
    }

    public function testIsFolder() 
    {
        $this->assertTrue(eden('utility')->folder(__DIR__.'/../../../assets')->isFolder());
        $this->assertFalse(eden('utility')->folder(__DIR__.'/../../../assets/stars.gif')->isFolder());
    }

    public function testRemove() 
    {
        $class = eden('utility')->folder(__DIR__.'/../../../assets/foobar')->remove();
        $this->assertInstanceOf('Eden\\Utility\\Folder', $class);

        $this->assertFalse(file_exists(__DIR__.'/../../../assets/foobar'));
    }

    public function testRemoveFiles() 
    {
        $path = __DIR__.'/../../../assets/foobar';
        eden('utility')->folder($path)->create(0777);
        eden('utility')->file($path.'/file1.txt')->touch();
        eden('utility')->file($path.'/2files.txt')->touch();
        eden('utility')->file($path.'/file3.txt')->touch();

        eden('utility')->folder($path)->removeFiles('/^file/');

        $this->assertTrue(file_exists($path.'/2files.txt'));
        $this->assertFalse(file_exists($path.'/file3.txt'));

        eden('utility')->folder($path)->removeFiles();
        $this->assertFalse(file_exists($path.'/2files.txt'));
    }

    public function testRemoveFolders() 
    {
        $path = __DIR__.'/../../../assets/foobar/subfolder';

        eden('utility')->folder($path)->create(0777);

        eden('utility')->folder(__DIR__.'/../../../assets/foobar')->removeFolders();

        $this->assertFalse(is_dir($path));

        eden('utility')->folder(__DIR__.'/../../../assets/foobar')->remove();
    }

    public function testTruncate() 
    {
        $path = __DIR__.'/../../../assets/foobar2';


        eden('utility')->folder($path)->create(0777);
        eden('utility')->folder($path.'/subfolder2')->create(0777);

        eden('utility')->file($path.'/file1.txt')->touch();
        eden('utility')->file($path.'/2files.txt')->touch();
        eden('utility')->file($path.'/file3.txt')->touch();

        eden('utility')->folder($path)->truncate();

        $this->assertFalse(is_dir($path.'/subfolder2'));
        $this->assertFalse(file_exists($path.'/2files.txt'));

        eden('utility')->folder($path)->remove();
    }
}