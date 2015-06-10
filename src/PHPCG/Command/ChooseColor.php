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
use Zend\Console\Prompt\Select;
use ZF\Console\Route;

/**
 * Class ChooseColor
 *
 * @package PHPCG\Command
 */
class ChooseColor
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
        $options = array(
            Color::BLACK  => 'BLACK',
            Color::RED    => 'RED',
            Color::GREEN  => 'GREEN',
            Color::YELLOW => 'YELLOW',
            Color::BLUE   => 'BLUE',
        );

        $prompt = new Select('Please choose any color: ', $options, false);

        $color = $prompt->show();

        $console->write('You have chosen ');
        $console->write(sprintf(' %s ', $options[$color]), Color::WHITE, $color);
        $console->writeLine('!');
    }
}
