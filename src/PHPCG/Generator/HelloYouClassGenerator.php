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
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Class HelloYouClassGenerator
 *
 * @package PHPCG\Generator
 */
class HelloYouClassGenerator
{
    /**
     * @var ClassGenerator
     */
    private $class;

    /**
     * @return ClassGenerator
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Create class
     */
    public function createClass()
    {
        $nameProperty = new PropertyGenerator('name');
        $nameProperty->addFlag(PropertyGenerator::FLAG_PRIVATE);

        $nameSetMethod = new MethodGenerator('setName');
        $nameSetMethod->addFlag(MethodGenerator::FLAG_PUBLIC);
        $nameSetMethod->setParameter(
            new ParameterGenerator('name')
        );
        $nameSetMethod->setBody(
            '$this->name = $name;'
        );

        $greetMethod = new MethodGenerator('greet');
        $greetMethod->addFlag(MethodGenerator::FLAG_PUBLIC);
        $greetMethod->setBody(
            'return sprintf("Hello %s!", $this->name);'
        );

        $this->class = new ClassGenerator('HelloYou', 'Hello\Greeting');
        $this->class->addPropertyFromGenerator($nameProperty);
        $this->class->addMethods(array($nameSetMethod, $greetMethod));
    }
}
