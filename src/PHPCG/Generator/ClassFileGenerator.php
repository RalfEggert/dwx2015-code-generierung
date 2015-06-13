<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Generator;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;

/**
 * Class ClassFileGenerator
 *
 * @package PHPCG\Generator
 */
class ClassFileGenerator extends FileGenerator
{
    /**
     * Create File for a class
     *
     * @param ClassGenerator $class
     */
    public function __construct(ClassGenerator $class)
    {
        $docBlock = new DocBlockGenerator(
            'Automatically generated file',
            'Please enter any project wide description for all files',
            array(
                array(
                    'name'        => 'package',
                    'description' => $class->getNamespaceName(),
                ),
                array(
                    'name'        => 'license',
                    'description' => 'MIT',
                )
            )
        );

        parent::__construct();
        $this->setClass($class);
        $this->setDocBlock($docBlock);
    }
}
