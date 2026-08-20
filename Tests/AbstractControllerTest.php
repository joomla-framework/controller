<?php

/**
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Controller\Tests;

use Joomla\Application\AbstractApplication;
use Joomla\Controller\AbstractController;
use Joomla\Input\Input;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Joomla\Controller\AbstractController class.
 */
#[CoversClass(AbstractController::class)]
class AbstractControllerTest extends TestCase
{
    /**
     * Object being tested
     *
     * @var  AbstractController
     */
    private $instance;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new TestController();
    }

    #[TestDox('Tests the controller is instantiated correctly')]
    public function test__constructDefaultBehaviour()
    {
        $this->assertNull($this->instance->getApplication());
        $this->assertNull($this->instance->getInput());
    }

    #[TestDox('Tests the controller is instantiated correctly')]
    public function test__constructDependencyInjection()
    {
        $mockInput = $this->createStub(Input::class);
        $mockApp   = $this->createStub(AbstractApplication::class);
        $object    = new TestController($mockInput, $mockApp);

        $this->assertSame($mockApp, $object->getApplication());
        $this->assertSame($mockInput, $object->getInput());
    }

    #[TestDox('Tests an application object is injected into the controller and retrieved correctly')]
    public function testSetAndGetApplication()
    {
        $mockApp = $this->createStub(AbstractApplication::class);

        $this->assertSame($this->instance, $this->instance->setApplication($mockApp), 'The setApplication method has a fluent interface');
        $this->assertSame($mockApp, $this->instance->getApplication());
    }

    #[TestDox('Tests an input object is injected into the controller and retrieved correctly')]
    public function testSetAndGetInput()
    {
        $mockInput = $this->createStub(Input::class);

        $this->assertSame($this->instance, $this->instance->setInput($mockInput), 'The setInput method has a fluent interface');
        $this->assertSame($mockInput, $this->instance->getInput());
    }
}

/**
 * Class TestController
 *
 * To have an instance of the class to test
 *
 * @package  Joomla\Controller\Tests
 * @since    1.0
 */
class TestController extends AbstractController {
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
