<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Command;

use PHPCG\Collector\MetaDataCollector;
use PHPCG\Generator\ClassFileGenerator;
use PHPCG\Generator\UserEntityGenerator;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as Color;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;
use ZF\Console\Route;

/**
 * Class CreateUserEntities
 *
 * @package PHPCG\Command
 */
class CreateUserEntities
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
        $dbConfig = include DWX2015_PHPCG_ROOT . '/config/db.php';
        $fileName = DWX2015_PHPCG_ROOT . '/tmp/UserEntity.php';

        $dbAdapter = new Adapter($dbConfig['adapter']);
        $metaData  = new Metadata($dbAdapter);
        $collector = new MetaDataCollector($metaData);

        $userColumns = $collector->fetchTableColumns('user');

        $classGenerator = new UserEntityGenerator();
        $classGenerator->createClass();
        $classGenerator->addEntityProperties($userColumns);
        $class = $classGenerator->getClass();

        $fileGenerator = new ClassFileGenerator();
        $fileGenerator->createFile($class);
        $file = $fileGenerator->getFile();

        file_put_contents($fileName, $file->generate());

        $console->write('Created class ' . $console->colorize($class->getName(), Color::YELLOW));
        $console->writeLine(' in file ' . $console->colorize(realpath($fileName), Color::YELLOW));
        $console->writeLine();
        $console->writeLine($file->generate());
        $console->writeLine();
    }
}
