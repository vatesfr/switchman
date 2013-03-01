<?php
/**
 * This file is a part of Switchman.
 *
 * Switchman is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Switchman is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Switchman. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Julien Fontanet <julien.fontanet@vates.fr>
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GPLv3
 *
 * @package Switchman
 */

namespace Switchman;

use Switchman\Context;
use Switchman\Builder;
use Switchman\Matcher;

/**
 * @todo Use matcher key to identify which matcher matched.
 */
final class Collection
{
	/**
	 * @param Builder[] $builders
	 * @param Matcher[] $matchers
	 */
	function __construct(array $builders, array $matchers)
	{
		$this->_builders = $builders;
		$this->_matchers = $matchers;
	}

	/**
	 * @param string $name Name of the route to build.
	 * @param array|null $parameters Parameters of the route.
	 *
	 * @return mixed The route (often a string).
	 */
	function build($name, array $parameters = null)
	{
		if (!isset($this->_builders[$name]))
		{
			trigger_error(
				'no such builder: '.$name,
				E_USER_ERROR
			);
		}

		$builder = &$this->_builders[$name];

		// Lazy construction of builders.
		if (is_array($builder))
		{
			$builder = $builder['class']::factory($builder['options']);
		}

		return $builder->build($parameters);
	}

	/**
	 * @param Context $context
	 *
	 * @return array|false
	 */
	function match(Context $context)
	{
		foreach ($this->_matchers as &$matcher)
		{
			// Lazy construction of matchers.
			if (is_array($matcher))
			{
				$matcher = $matcher['class']::factory($matcher['options']);
			}

			$result = $matcher->match($context);
			if (false !== $result)
			{
				return $result;
			}
		}

		return false;
	}

	/**
	 * @var Matcher[]
	 */
	private $_matchers;

	/**
	 * @var Builder[]
	 */
	private $_builders;
}
