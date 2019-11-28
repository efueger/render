<?php

declare(strict_types=1);

/**
 * This file is part of mobicms/render library
 *
 * @license     https://opensource.org/licenses/MIT MIT (see the LICENSE file)
 * @link        http://mobicms.org mobiCMS Project
 */

namespace Mobicms\Render\Template;

use LogicException;

/**
 * A collection of template functions
 */
class Functions
{
    /** @var array Array of template functions */
    protected $functions = [];

    /**
     * Add a new template function
     *
     * @param string   $name
     * @param callable $callback
     * @return Functions
     */
    public function add(string $name, callable $callback) : self
    {
        if ($this->exists($name)) {
            throw new LogicException(
                'The template function name "' . $name . '" is already registered.'
            );
        }

        $this->functions[$name] = new Func($name, $callback);

        return $this;
    }

    /**
     * Remove a template function
     *
     * @param string $name
     * @return Functions
     */
    public function remove(string $name) : self
    {
        if (! $this->exists($name)) {
            throw new LogicException(
                'The template function "' . $name . '" was not found.'
            );
        }

        unset($this->functions[$name]);

        return $this;
    }

    /**
     * Get a template function
     *
     * @param string $name
     * @return Func
     */
    public function get(string $name) : Func
    {
        if (! $this->exists($name)) {
            throw new LogicException('The template function "' . $name . '" was not found.');
        }

        return $this->functions[$name];
    }

    /**
     * Check if a template function exists
     *
     * @param string $name
     * @return bool
     */
    public function exists(string $name) : bool
    {
        return isset($this->functions[$name]);
    }
}
