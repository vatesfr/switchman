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

use Switchman\Collection;
use Switchman\Context;

//--------------------------------------

/* Let's create two route builders and two route matchers.
 *
 * You may notice that for performance reason we use lazy creation for
 * both builders and matchers. This is not necessary but recommended.
 *
 * Another thing you may notice is that, while builders MUST have
 * a name, it is only optional for matchers but may be very useful to
 * know which route has matched.
 */
$builders = array(
	'home'  => array(
		'class'   => '\Switchman\Builder\Simple',
		'options' => array(
			'pattern' => '/'
		),
	),
	'admin'  => array(
		'class'   => '\Switchman\Builder\Simple',
		'options' => array(
			'pattern'  => '/admin/:action',
			'defaults' => array(
				'action' => 'index',
			),
		),
	),
);
$matchers = array(
	array(
		'class'   => '\Switchman\Matcher\Regex',
		'options' => array(
			'patterns' => array(
				'path' => ',^/(?<controller>[a-z]+)(?:/(?<action>[a-z]+))?$,',
			),
			'defaults' => array(
				'controller' => 'home',
				'action'     => 'index',
			),
		),
	),
);

// We can now create our routes collection.
$collection = new Collection($builders, $matchers);

// With this collection, we can build routes.
$route = $collection->build('home');
echo $route, PHP_EOL;
$route = $collection->build('admin', array(
	'action' => 'logIn',
));
echo $route, PHP_EOL;

// We can also match routes.
$context = new Context(array(
	'path' => '/users',
));
$parameters = $collection->match($context);
var_export($parameters);
echo PHP_EOL;
