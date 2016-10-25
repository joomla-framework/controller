<?php
/**
 * @copyright  Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Renderer\Tests;

use Joomla\Renderer\PhpEngineRenderer;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Test class for \Joomla\Renderer\PhpEngineRenderer.
 */
class PhpEngineRendererTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @testdox  The PhpEngine renderer is instantiated with injected parameters
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::__construct
	 */
	public function testThePhpEngineRendererIsInstantiatedWithInjectedParameters()
	{
		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertAttributeSame($engine, 'renderer', $renderer);
	}

	/**
	 * @testdox  Adding paths to the loader is unsupported
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::addFolder()
	 */
	public function testAddingPathsToTheLoaderIsUnsupported()
	{
		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertSame($renderer, $renderer->addFolder(__DIR__ . '/stubs/templating'), 'Validates $this is returned');
	}

	/**
	 * @testdox  The rendering engine is returned
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::getRenderer
	 */
	public function testTheRenderingEngineIsReturned()
	{
		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertSame($engine, $renderer->getRenderer());
	}

	/**
	 * @testdox  Check that a path exists
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::pathExists
	 */
	public function testCheckThatAPathExists()
	{
		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertTrue($renderer->pathExists('index.php'));
	}

	/**
	 * @testdox  The template is rendered
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::render
	 */
	public function testTheTemplateIsRendered()
	{
		$path = __DIR__ . '/stubs/templating';

		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertSame(file_get_contents($path . '/index.php'), $renderer->render('index.php'));
	}

	/**
	 * @testdox  Setting the file extension is unsupported
	 *
	 * @covers   \Joomla\Renderer\PhpEngineRenderer::setFileExtension
	 */
	public function testSettingTheFileExtensionIsUnsupported()
	{
		$engine   = $this->makeEngine();
		$renderer = new PhpEngineRenderer($engine);

		$this->assertSame($renderer, $renderer->setFileExtension('php'), 'Validates $this is returned');
	}

	/**
	 * Make the PhpEngine instance for testing
	 *
	 * @return  PhpEngine
	 */
	private function makeEngine()
	{
		return new PhpEngine(new TemplateNameParser, new FilesystemLoader([__DIR__ . '/stubs/templating/%name%']));
	}
}
