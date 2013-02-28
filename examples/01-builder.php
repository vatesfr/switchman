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

use Switchman\Builder\Simple;

//--------------------------------------

// Let's create a new Simple route builder.
$builder = new Simple(
	'/:controller/:action',
	array(
		'action' => 'index',
	)
);

// Builds the route providing all parameters.
$route = $builder->build(array(
	'controller' => 'home',
	'action'     => 'about',
));
echo $route, PHP_EOL;

// Use the default value for “action”.
$route = $builder->build(array(
	'controller' => 'admin',
));
echo $route, PHP_EOL;

/* If we do not provide a value for controller, a fatal error will be
 * triggered.
 */
$route = $builder->build(array(
	'action' => 'about',
));
echo $route, PHP_EOL; // Not executed.
