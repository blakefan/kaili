<?php

namespace Kaili;

require_once dirname(__FILE__).'/../../../kaili/file.php';

/**
 * Test class for File.
 * Generated by PHPUnit on 2011-10-16 at 20:05:25.
 */
class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var File
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $test_files = array(
            ROOT.DS.'test.txt',
            ROOT.DS.'test_new.txt',
            ROOT.DS.'test.tx',
            ROOT.DS.'test',
            SYSTEM.DS.'test.txt',
        );
        foreach($test_files as $f){
            file_exists($f) and unlink($f);
        }
    }

    /**
     * Test for File::factory()
     * @test
     */
    public function test_factory()
    {
        $object = File::factory(ROOT.DS.'index.php');
        $this->assertEquals($object->get_path(), ROOT.DS.'index.php');
    }
    
    /**
     * Test for File::factory()
     * The file doesn't exist.
     * Throws Kaili\Exception because the provided file doesn't exist.
     * @test
     * @expectedException \Kaili\FileException
     */
    public function test_factory_not_exist()
    {
        File::factory(ROOT.DS.'test.txt');
    }
    
    /**
     * Test for File::create()
     * @test
     */
    public function test_create()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $this->assertEquals($object->get_path(), ROOT.DS.'test.txt');
    }
    
    /**
     * Test for File::create()
     * The file already exist.
     * Throws Exception because provided path is an already existent file
     * @test
     * @expectedException \Kaili\FileException
     */
    public function test_create_exists()
    {
        File::create(ROOT.DS.'index.php');
    }

    /**
     * Test for File::rename()
     * Create a new file named test.txt and renames it as test_new.txt.
     * At the end of the test, remove the created file.
     * @test
     */
    public function test_rename()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->rename('test_new.txt');
        $this->assertEquals($object->get_base_name(), 'test_new.txt');
    }
    
    /**
     * Test for File::rename()
     * Create a new file named test.txt and renames it with the same name.
     * At the end of the test, remove the created file.
     * @test
     */
    public function test_rename_same_name()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->rename('test.txt');
        $this->assertEquals($object->get_base_name(), 'test.txt');
    }
    
    /**
     * Test for File::rename()
     * Create a new file named test.txt and renames it changing extension to 'tx'.
     * At the end of the test, remove the created file.
     * @test
     */
    public function test_rename_ext()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->rename('test.tx');
        $this->assertEquals($object->get_name(), 'test');
        $this->assertEquals($object->get_extension(), 'tx');
    }
    
    /**
     * Test for File::rename()
     * Create a new file named test.txt and renames it without extension.
     * At the end of the test, remove the created file.
     * @test
     */
    public function test_rename_no_ext()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->rename('test');
        $this->assertEquals($object->get_name(), 'test');
        $this->assertEquals($object->get_extension(), '');
    }

    /**
     * Test for File::move()
     * Create the file test.txt in [ROOT] and moves it to [SYSTEM]
     * At the end of the test, remove the moved file.
     * @test
     */
    public function test_move()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->move(SYSTEM);
        $this->assertTrue(file_exists(SYSTEM.DS.'test.txt'));
        $this->assertFalse(file_exists(ROOT.DS.'test.txt'));
        $this->assertEquals($object->get_path(), SYSTEM.DS.'test.txt');
    }
    
     /**
     * Test for File::move()
     * Attempts to move [ROOT]/test.txt to [ROOT] with overwriting disabled
     * Throws \Kaili\FileException because file alredy exists
     * @expectedException \Kaili\FileException
     * @test
     */
    public function test_move_file_exists()
    {
        $object = File::create(ROOT.DS.'test.txt');
        $object->move(ROOT, false);
    }
    
    /**
     * Test for File::move()
     * Attempts to move [ROOT]/index.php to [ROOT]/not_exist
     * Throws \Kaili\FileException because provided path doesn't exist
     * @expectedException \Kaili\FileException
     * @test
     */
    public function test_move_not_exists_dir()
    {
        $object = File::factory(ROOT.DS.'index.php');
        $object->move(ROOT.DS.'not_exist');
    }

    /**
     * Test for File::remove()
     * Create and remove [ROOT]/test.txt
     * @test
     */
    public function test_remove()
    {
        $path = ROOT.DS.'test.txt';
        $object = File::create($path);
        $object->remove($path);
        $this->assertFalse(file_exists($path));
    }

    /**
     * Test for File::read()
     * Create a file [ROOT]/test.txt, write a string 'this is a test string' and read it.
     * @test
     */
    public function test_read()
    {
        $fp = fopen(ROOT.DS.'test.txt', 'w');
        fprintf($fp, '%s', 'this is a test string');
        fclose($fp);
        
        $object = File::factory(ROOT.DS.'test.txt');
        $str = $object->read();
        $this->assertEquals($str, 'this is a test string');
    }

    /**
     * Test for File::write()
     * Create a file [ROOT]/test.txt and write a string 'this is a test string'.
     * @test
     */
    public function test_write()
    {        
        $object = File::create(ROOT.DS.'test.txt');
        $object->write('this is a test string');
        $this->assertEquals($object->read(), 'this is a test string');
    }

    /**
     * Test for File::append()
     * Create a file [ROOT]/test.txt, write a string 'this is a test string' and
     * append a string 'this is an append test string'.
     * @test
     */
    public function test_append()
    {        
        $object = File::create(ROOT.DS.'test.txt');
        $object->write('this is a test string');
        $object->append("\nthis is an appended test string");
        $this->assertEquals($object->read(), "this is a test string\nthis is an appended test string");
    }
}

?>
