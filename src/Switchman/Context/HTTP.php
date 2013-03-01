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

namespace Switchman\Context;

use Switchman\Context;

/**
 * @todo Use an array for the constructor.
 */
final class HTTP extends Context
{
	/**
	 * @param boolean $logical Whether to use the logical path instead
	 *     of the real one. The logical path starts from the script's
	 *     root and handles path info and mod rewrite.
	 *
	 * @return HTTP
	 */
	static function createFromGlobals($logical = false)
	{
		$_ = explode('?', $_SERVER['REQUEST_URI'], 2);
		$path  = $_[0];
		$query = isset($_[1]) ? $_[1] : null;

		if (!$logical)
		{
			$base = null;
		}
		elseif (isset($_SERVER['PATH_INFO']))
		{
			$base = $_SERVER['PHP_SELF'];
			$path = $_SERVER['PATH_INFO'];
		}
		else
		{
			$n = strrpos($_SERVER['PHP_SELF'], '/');

			$base = substr($path, 0, $n); // Current script directory.
			$path = substr($path, $n);    // Removes the current script directory.
		}

		return new self(
			isset($_SERVER['https']) || isset($_SERVER['HTTPS']),
			$_SERVER['HTTP_HOST'],
			$_SERVER['SERVER_PORT'],
			$_SERVER['REQUEST_METHOD'],
			$path,
			$query,
			$_GET,
			$_POST,
			$base
		);
	}

	/**
	 * @param array $properties
	 */
	function __construct(
		$https  = null,    // null|boolean
		$host   = null,    // null|string
		$port   = null,    // null|string
		$method = null,    // null|string
		$path   = null,    // null|string
		$query  = null,    // null|string
		$get_vars  = null, // null|array
		$post_vars = null, // null|array
		$base_path = null  // null|string
	)
	{
		parent::__construct(get_defined_vars());
	}
}
