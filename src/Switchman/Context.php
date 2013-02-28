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

/**
 *
 */
class Context implements
	\ArrayAccess,
	\Countable,
	\IteratorAggregate
{
	/**
	 * @param array $properties
	 */
	function __construct(array $properties)
	{
		$this->_properties = $properties;
	}

	/**
	 *
	 */
	function __destruct()
	{}

	//--------------------------------------

	/**
	 *
	 */
	function offsetGet($offset)
	{
		if (!$this->offsetExists($offset))
		{
			trigger_error(
				'no such offset',
				E_USER_ERROR
			);
		}

		return $this->_properties[$offset];
	}

	/**
	 *
	 */
	function offsetExists($offset)
	{
		return (isset($this->_properties[$offset])
		        || array_key_exists($offset, $this->_properties));
	}

	/**
	 *
	 */
	function offsetSet($offset, $value)
	{
		trigger_error(
			get_class($this).'['.var_export($index, true).'] is not writable',
			E_USER_ERROR
		);
	}

	/**
	 *
	 */
	function offsetUnset($index)
	{
		trigger_error(
			get_class($this).'['.var_export($index, true).'] is not writable',
			E_USER_ERROR
		);
	}

	//--------------------------------------

	/**
	 * @return integer
	 */
	function count()
	{
		return count($this->_properties);
	}

	//--------------------------------------

	/**
	 *
	 */
	function getIterator()
	{
		return \ArrayIterator($this->_properties);
	}
}
