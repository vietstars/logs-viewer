<?php

namespace vietstars\LogsViewer;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use File;

/**
 * Class LogsViewerTest
 * @package vietstars\LogsViewer
 */
class LogsViewerTest extends OrchestraTestCase
{

    public function setUp()
    {
        parent::setUp();
        config()->set('app.key', 'XP0aw2Dkrk22p0JoAOzulOl8XkUxlvkO');
        // Copy "laravel.log" file to the orchestra package.
        if (!file_exists(storage_path('logs/laravel.log'))) {
            copy(__DIR__ . '/laravel.log', storage_path('logs/laravel.log'));
        }
    }

    /**
     * @throws \Exception
     */
    public function testSetFile()
    {

        $logsViewer = new LogsViewer();
        $logsViewer->setFile("laravel.log");

        $this->assertEquals("laravel.log", $logsViewer->getFileName());
    }


    public function testSetFolderWithCorrectPath()
    {

        $logsViewer = new LogsViewer();
        $logsViewer->setFolder(basename((__DIR__)));
        $this->assertEquals("tests", $logsViewer->getFolderName());
    }


    public function testSetFolderWithArrayStoragePath()
    {
        $path = __DIR__;
        
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath([$path]);
        if(!\File::exists("$path/samuel")) \File::makeDirectory("$path/samuel");
        $logsViewer->setFolder('samuel');
        
        $this->assertEquals("samuel", $logsViewer->getFolderName());

    }

    public function testSetFolderWithDefaultStoragePath()
    {
      
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(storage_path());
        $logsViewer->setFolder('logs');

        
        $this->assertEquals("logs", $logsViewer->getFolderName());

    }

    public function testSetStoragePath()
    {

        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(basename(__DIR__));

        $this->assertEquals("tests", $logsViewer->getStoragePath());
    }

    public function testPathToLogFile()
    {

        $logsViewer = new LogsViewer();
        $pathToLogFile = $logsViewer->pathToLogFile(storage_path(('logs/laravel.log')));
        
        $this->assertEquals($pathToLogFile, storage_path('logs/laravel.log'));
    }

    public function testPathToLogFileWithArrayStoragePath()
    {

        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath([storage_path()]);
        $pathToLogFile = $logsViewer->pathToLogFile('laravel.log');

        $this->assertEquals($pathToLogFile, 'laravel.log');
    }

    public function testFailOnBadPathToLogFile()
    {

        $this->expectException(\Exception::class);

        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(storage_path());
        $logsViewer->setFolder('logs');
        $logsViewer->pathToLogFile('newlogs/nolaravel.txt');
    }

    public function testAll()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(__DIR__);
        $logsViewer->pathToLogFile(storage_path('logs/laravel.log'));
        $data = $logsViewer->all();
        $this->assertEquals('local', $data[0]['context']);
        $this->assertEquals('error', $data[0]['level']);
        $this->assertEquals('danger', $data[0]['level_class']);
        $this->assertEquals('exclamation-triangle', $data[0]['level_img']);
        $this->assertEquals('2018-09-05 20:20:51', $data[0]['date']);
    }

    public function testAllWithEmptyFileName()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(__DIR__);
        
        $data = $logsViewer->all();
        $this->assertEquals('local', $data[0]['context']);
        $this->assertEquals('error', $data[0]['level']);
        $this->assertEquals('danger', $data[0]['level_class']);
        $this->assertEquals('exclamation-triangle', $data[0]['level_img']);
        $this->assertEquals('2018-09-05 20:20:51', $data[0]['date']);
    }

    public function testFolderFiles()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(__DIR__);
        $data = $logsViewer->foldersAndFiles();
        $this->assertIsArray($data);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        
        $this->assertStringContainsString('tests',  $data[count(explode($data[0], '/')) - 1]);
    }

    public function testGetFolderFiles()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(__DIR__);
        $data = $logsViewer->getFolderFiles();
        
        $this->assertIsArray($data);
        $this->assertNotEmpty($data, "Folder files is null");
    }

    public function testGetFiles()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(storage_path());
        $data = $logsViewer->getFiles();
  
        $this->assertIsArray($data);
        $this->assertNotEmpty($data, "Folder files is null");
    }

    public function testGetFolders()
    {
        $logsViewer = new LogsViewer();
        $logsViewer->setStoragePath(storage_path());
        $data = $logsViewer->getFolders();
  
        $this->assertIsArray($data);
        $this->assertNotEmpty($data, "files is null");
    }

    public function testDirectoryStructure()
    {
        $logsViewer = new LogsViewer();
        ob_start();
        $logsViewer->directoryTreeStructure(storage_path('logs'), $logsViewer->foldersAndFiles());
        $data = ob_get_clean();
        
        $this->assertIsString($data);
        $this->assertNotEmpty($data);
    }


}
