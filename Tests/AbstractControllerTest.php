<?php
/**
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Controller\Tests;

use Joomla\Application\AbstractApplication;
use Joomla\Controller\AbstractController;
use Joomla\Input\Input;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Joomla\Controller\AbstractController class.
 */
class AbstractControllerTest extends TestCase
{
	/**
	 * Object being tested
	 *
	 * @var  MockObject|AbstractController
	 */
	private $instance;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->instance = $this->getMockForAbstractClass(AbstractController::class);
	}

	/**
	 * @testdox  Tests the controller is instantiated correctly
	 */
	public function test__constructDefaultBehaviour()
	{
		$this->assertNull($this->instance->getApplication());
		$this->assertNull($this->instance->getInput());
	}

	/**
	 * @testdox  Tests the controller is instantiated correctly
	 */
	public function test__constructDependencyInjection()
	{
		$mockInput = $this->createMock(Input::class);

		$mockApp = $this->getMockForAbstractClass(AbstractApplication::class);
		$object  = $this->getMockForAbstractClass(AbstractController::class, [$mockInput, $mockApp]);

		$this->assertSame($mockApp, $object->getApplication());
		$this->assertSame($mockInput, $object->getInput());
	}

	/**
	 * @testdox  Tests an application object is injected into the controller and retrieved correctly
	 */
	public function testSetAndGetApplication()
	{
		$mockApp = $this->getMockForAbstractClass(AbstractApplication::class);

		$this->instance->setApplication($mockApp);
		$this->assertSame($mockApp, $this->instance->getApplication());
	}

	/**
	 * @testdox  Tests an input object is injected into the controller and retrieved correctly
	 */
	public function testSetAndGetInput()
	{
		$mockInput = $this->createMock(Input::class);

		$this->instance->setInput($mockInput);
		$this->assertSame($mockInput, $this->instance->getInput());
	}
}
