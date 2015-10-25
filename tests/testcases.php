<?php

namespace tests;

use PHPUnit_Framework_Testcase;
use Drips\ClassLoader\ClassLoader;
use tests\example\Example;
use example\Other;

// load and register classloader
require_once __DIR__.'/../src/classloader.php';
$classloader = new ClassLoader();

class TestCases extends PHPUnit_Framework_TestCase
{
    public function testCanLoadTestClass()
    {
        $this->assertEquals(TestClass::hello(), 'Hello');
    }

    public function testCanLoadExample()
    {
        $this->assertTrue(Example::isTrue());
    }

    public function testCanLoadOther()
    {
        $classloader = new ClassLoader;
        $classloader->registerNamespace('example', __DIR__);
        $this->assertTrue(Other::isTrue());
    }

    public function testCanNotLoad()
    {
        $this->assertFalse(is_callable("NotRealClass::test"));
    }
}
