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

namespace Switchman\Matcher;

use Switchman\Context;
use Switchman\Matcher;

/**
 * @todo Add a factory.
 */
final class Regex implements Matcher
{
	/**
	 * @param array $options
	 *
	 * @return Regex
	 */
	static function factory(array $options)
	{
		return new self(
			$options['patterns'],
			isset($options['defaults']) ? $options['defaults'] : null
		);
	}

	/**
	 * @param array $patterns
	 * @param array|null $defaults
	 */
	function __construct(array $patterns, array $defaults = null)
	{
		$this->_patterns = $patterns;
		$this->_defaults = $defaults ?: array();
	}

	/**
	 * @param Context $context
	 *
	 * @return array|false
	 */
	function match(Context $context)
	{
		$parameters = array();
		foreach ($this->_patterns as $key => $pattern)
		{
			if (!preg_match($pattern, $context[$key], $matches))
			{
				return false;
			}

			foreach ($matches as $key => $match)
			{
				if (is_numeric($key))
				{
					unset($matches[$key]);
				}
			}
			$parameters = $matches + $parameters;
		}
		return ($parameters + $this->_defaults);
	}

	/**
	 * @var string[]
	 */
	protected $_patterns;

	/**
	 * @var array $defaults
	 */
	protected $_defaults;
}
