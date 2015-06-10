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
use Zend\Console\Prompt\Line;
use ZF\Console\Route;

/**
 * Class HelloSomeOne
 *
 * @package PHPCG\Command
 */
class HelloSomeOne
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
        $prompt = new Line('Please enter any name: ', false);

        $you = $prompt->show();

        $console->write('Hello');
        $console->write(sprintf(' %s', $you), Color::RED);
        $console->writeLine('...');
    }
}
