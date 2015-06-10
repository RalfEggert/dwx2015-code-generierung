#!/usr/bin/env php
<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
use Zend\Console\Console;
use ZF\Console\Application;

// define application root
define('DWX2015_PHPCG_ROOT', __DIR__ . '/..');

// get vendor autoloading
include DWX2015_PHPCG_ROOT . '/vendor/autoload.php';

// define our current version
define('VERSION', '1.0.0');

// get routes
$routes = include DWX2015_PHPCG_ROOT . '/config/routes.php';

// get console
$console = Console::getInstance();

// build line
$line = str_pad('-', $console->getWidth(), '-');

// start new application
$application = new Application(
    'DWX2015 PHP Code Generator',
    VERSION,
    $routes,
    $console
);
$application->setFooter($line);

// run application
$exit = $application->run();
exit($exit);