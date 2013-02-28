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

require(__DIR__.'/../vendor/autoload.php');

use Switchman\Context;
use Switchman\Matcher\Regex;

//--------------------------------------

/* Let's create a new Regex route matcher.
 *
 * It will match for only if both regexes are satisfied.
 */
$matcher = new Regex(
	array(
		'method' => ',^get$,i',
		'path'   => ',^/(?P<controller>[a-z]+)(?:/(?P<action>[a-z]+))?$,',
	),
	array(
		'action' => 'index',
	)
);

// Matchs the route providing all parameters.
$parameters = $matcher->match(new Context(array(
	'method' => 'get',
	'path'   => '/home/about',
)));
var_export($parameters);
echo PHP_EOL;

// Without specifying the action, we'll get the default.
$parameters = $matcher->match(new Context(array(
	'method' => 'get',
	'path'   => '/home',
)));
var_export($parameters);
echo PHP_EOL;

// Invalid route, we'll get “false”.
$parameters = $matcher->match(new Context(array(
	'method' => 'get',
	'path'   => '/',
)));
var_export($parameters);
echo PHP_EOL;
