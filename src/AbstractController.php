<?php

/**
 * Part of the Joomla Framework Controller Package
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Controller;

use Joomla\Application\ApplicationInterface;
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
     * @var    ApplicationInterface|null
     * @since  1.0
     */
    private ?ApplicationInterface $app = null;

    /**
     * The input object.
     *
     * @var    Input|null
     * @since  1.0
     */
    private ?Input $input = null;

    /**
     * Instantiate the controller.
     *
     * @param   ?Input                 $input  The input object.
     * @param   ?ApplicationInterface  $app    The application object.
     *
     * @since   1.0
     */
    public function __construct(?Input $input = null, ?ApplicationInterface $app = null)
    {
        $this->input = $input;
        $this->app   = $app;
    }

    /**
     * Get the application object.
     *
     * @return  ApplicationInterface
     *
     * @since   1.0
     * @throws  \UnexpectedValueException if the application has not been set.
     */
    public function getApplication(): ApplicationInterface
    {
        if ($this->app === null) {
            throw new \UnexpectedValueException('Application not set in ' . static::class);
        }

        return $this->app;
    }

    /**
     * Get the input object.
     *
     * @return  Input
     *
     * @since   1.0
     * @throws  \UnexpectedValueException if the input object has not been set.
     */
    public function getInput(): Input
    {
        if ($this->input === null) {
            throw new \UnexpectedValueException('Input object not set in ' . static::class);
        }

        return $this->input;
    }

    /**
     * Set the application object.
     *
     * @param   ApplicationInterface  $app  The application object.
     *
     * @return  $this
     *
     * @since   1.0
     */
    public function setApplication(ApplicationInterface $app): static
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
    public function setInput(Input $input): static
    {
        $this->input = $input;

        return $this;
    }
}
