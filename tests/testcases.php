<?php

namespace tests;

use PHPUnit_Framework_Testcase;
use Drips\ClassLoader\ClassLoader;

// load and register classloader
require_once __DIR__.'/../src/classloader.php';
$classloader = new ClassLoader();
$classloader->extensions[] = '.class.php';

class TestCases extends PHPUnit_Framework_TestCase
{
    public function testCanLoadTestClass()
    {
        $this->assertTrue(class_exists("tests\\TestClass"));
    }

    public function testCanLoadExample()
    {
        $this->assertTrue(class_exists("tests\\example\\Example"));
    }

    public function testCanLoadOther()
    {
        $this->assertFalse(class_exists("example\\Other"));
        $classloader = new ClassLoader;
        $classloader->extensions[] = '.inc.php';
        $classloader->registerNamespace('example', __DIR__);
        $this->assertTrue(class_exists("example\\Other"));
    }

    public function testLoadDir()
    {
        $this->assertFalse(class_exists("own\\test"));
        $classloader = new ClassLoader();
        $classloader->load_dir = __DIR__."/example";
        $this->assertTrue(class_exists("own\\test"));
    }

    public function testCanNotLoad()
    {
        $this->assertFalse(class_exists("NotRealClass"));
    }
}
