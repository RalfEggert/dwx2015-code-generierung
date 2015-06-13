<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Command;

use PHPCG\Generator\ClassFileGenerator;
use PHPCG\Generator\HelloYouClassGenerator;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as Color;
use ZF\Console\Route;

/**
 * Class CreateHelloYouClass
 *
 * @package PHPCG\Command
 */
class CreateHelloYouClass
{
    /**
     * Create a new hello you class
     *
     * @param  Route   $route
     * @param  Console $console
     *
     * @return int     Exit status
     */
    public function __invoke(Route $route, Console $console)
    {
        $fileName = realpath(DWX2015_PHPCG_ROOT . '/tmp/HelloYouClass.php');

        $class = new HelloYouClassGenerator();
        $file  = new ClassFileGenerator($class);

        file_put_contents($fileName, $file->generate());

        $console->write('Created class ' . $console->colorize($class->getName(), Color::YELLOW));
        $console->writeLine(' in file ' . $console->colorize($fileName, Color::YELLOW));
        $console->writeLine();
        $console->writeLine($file->generate());
        $console->writeLine();
    }
}
