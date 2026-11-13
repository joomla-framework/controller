<?php

/**
 * Part of the Joomla Framework Controller Package
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Controller;

use Joomla\Application\AbstractApplication;
use Joomla\Input\Input;

/**
 * Joomla Framework Base Controller Class
 *
 * @since  1.0
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * The application object.
     *
     * @var    AbstractApplication
     * @since  1.0
     */
    private $app;

    /**
     * The input object.
     *
     * @var    Input
     * @since  1.0
     */
    private $input;

    /**
     * Instantiate the controller.
     *
     * @param   ?Input                $input  The input object.
     * @param   ?AbstractApplication  $app    The application object.
     *
     * @since   1.0
     */
    public function __construct(?Input $input = null, ?AbstractApplication $app = null)
    {
        $this->input = $input;
        $this->app   = $app;
    }

    /**
     * Get the application object.
     *
     * Calling this method while no application is set is deprecated: it returns null in 4.x and will throw an
     * UnexpectedValueException in 5.0. Use hasApplication() to check first.
     *
     * @return  AbstractApplication|null
     *
     * @since   1.0
     */
    public function getApplication()
    {
        if ($this->app === null) {
            trigger_deprecation(
                'joomla/controller',
                '__DEPLOY_VERSION__',
                'Calling %s::getApplication() without an application set is deprecated and will throw an %s in 5.0.'
                . ' Use hasApplication() to check whether an application is set.',
                static::class,
                \UnexpectedValueException::class
            );
        }

        return $this->app;
    }

    /**
     * Get the input object.
     *
     * Calling this method while no input object is set is deprecated: it returns null in 4.x and will throw an
     * UnexpectedValueException in 5.0. Use hasInput() to check first.
     *
     * @return  Input|null
     *
     * @since   1.0
     */
    public function getInput()
    {
        if ($this->input === null) {
            trigger_deprecation(
                'joomla/controller',
                '__DEPLOY_VERSION__',
                'Calling %s::getInput() without an input object set is deprecated and will throw an %s in 5.0.'
                . ' Use hasInput() to check whether an input object is set.',
                static::class,
                \UnexpectedValueException::class
            );
        }

        return $this->input;
    }

    /**
     * Check whether an application object is set.
     *
     * @return  boolean
     *
     * @since   __DEPLOY_VERSION__
     */
    public function hasApplication(): bool
    {
        return $this->app !== null;
    }

    /**
     * Check whether an input object is set.
     *
     * @return  boolean
     *
     * @since   __DEPLOY_VERSION__
     */
    public function hasInput(): bool
    {
        return $this->input !== null;
    }

    /**
     * Set the application object.
     *
     * @param   AbstractApplication  $app  The application object.
     *
     * @return  $this
     *
     * @since   1.0
     */
    public function setApplication(AbstractApplication $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Set the input object.
     *
     * @param   Input  $input  The input object.
     *
     * @return  $this
     *
     * @since   1.0
     */
    public function setInput(Input $input)
    {
        $this->input = $input;

        return $this;
    }
}
