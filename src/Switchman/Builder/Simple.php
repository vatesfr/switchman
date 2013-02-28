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

namespace Switchman\Builder;

use Switchman\Builder;

/**
 *
 */
final class Simple implements Builder
{
	/**
	 * @param array $options
	 *
	 * @return Simple
	 */
	static function factory(array $options)
	{
		return new self(
			$options['pattern'],
			isset($options['defaults']) ? $options['defaults'] : null
		);
	}

	/**
	 * @param string $pattern
	 * @param array|null $defaults
	 */
	function __construct($pattern, array $defaults = null)
	{
		$this->_pattern  = $pattern;
		$this->_defaults = $defaults ?: array();
	}

	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	function build(array $parameters = null)
	{
		$parameters
			or $parameters = array();

		$parameters += $this->_defaults;

		$callback = function (array $matches) use ($parameters) {
			if (!isset($parameters[$matches[1]]))
			{
				trigger_error(
					'no such parameter: '.$matches[1],
					E_USER_ERROR
				);
			}
			return (string) $parameters[$matches[1]];
		};

		return preg_replace_callback(',:([a-z0-9]+),', $callback, $this->_pattern);
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
