<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Command;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as Color;
use ZF\Console\Route;

/**
 * Class HelloYou
 *
 * @package PHPCG\Command
 */
class HelloYou
{
    /**
     * Say hello to the world
     *
     * @param  Route   $route
     * @param  Console $console
     *
     * @return int     Exit status
     */
    public function __invoke(Route $route, Console $console)
    {
        $you = $route->getMatchedParam('you');

        $console->write('Hello ');
        $console->write(sprintf('"%s"', $you), Color::YELLOW);
        $console->writeLine(' ...');
    }
}
