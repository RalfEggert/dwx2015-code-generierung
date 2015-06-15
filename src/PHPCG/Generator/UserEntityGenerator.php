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
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\ValueGenerator;
use Zend\Filter\Word\UnderscoreToCamelCase;

/**
 * Class UserEntityGenerator
 *
 * @package PHPCG\Generator
 */
class UserEntityGenerator
{
    /**
     * @var ClassGenerator
     */
    private $class;

    /**
     * @var UnderscoreToCamelCase
     */
    private $filterUnderscoreToCamelCase;

    /**
     * Create UserEntity
     */
    public function __construct()
    {
        $this->filterUnderscoreToCamelCase = new UnderscoreToCamelCase();
    }

    /**
     * @return ClassGenerator
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Init entity class
     */
    public function createClass()
    {
        $this->class = new ClassGenerator('UserEntity', 'User\Entity');

        $this->class->setDocBlock(
            new DocBlockGenerator(
                'Class User\Entity',
                null,
                array(
                    array(
                        'name'        => 'author',
                        'description' => 'Ralf Eggert',
                    )
                )
            )
        );
    }

    /**
     * Add properties to entity class
     *
     * @param array $columns
     */
    public function addEntityProperties(array $columns = array())
    {
        foreach ($columns as $name => $attributes) {
            $property  = $this->generateProperty($name, $attributes);
            $getMethod = $this->generateGetMethod($name, $attributes);
            $setMethod = $this->generateSetMethod($name, $attributes);

            $this->class->addPropertyFromGenerator($property);
            $this->class->addMethodFromGenerator($getMethod);
            $this->class->addMethodFromGenerator($setMethod);
        }
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return PropertyGenerator
     */
    private function generateProperty($name, array $attributes = array())
    {
        $property = new PropertyGenerator($name);
        $property->addFlag(PropertyGenerator::FLAG_PRIVATE);
        $property->setDocBlock(
            new DocBlockGenerator(
                $name . ' property',
                null,
                array(
                    array(
                        'name'        => 'var',
                        'description' => $attributes['type'],
                    )
                )
            )
        );

        return $property;
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return MethodGenerator
     */
    private function generateGetMethod($name, array $attributes = array())
    {
        $methodName = 'get' . $this->filterUnderscoreToCamelCase->filter($name);

        $getMethod = new MethodGenerator($methodName);
        $getMethod->addFlag(MethodGenerator::FLAG_PUBLIC);
        $getMethod->setDocBlock(
            new DocBlockGenerator(
                'Get ' . $name,
                null,
                array(
                    array(
                        'name'        => 'return',
                        'description' => $attributes['type'],
                    )
                )
            )
        );
        $getMethod->setBody('return $this->' . $name . ';');

        return $getMethod;
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return MethodGenerator
     */
    private function generateSetMethod($name, array $attributes = array())
    {
        $methodName   = 'set' . $this->filterUnderscoreToCamelCase->filter($name);
        $defaultValue = !$attributes['required'] ? new ValueGenerator(null) : null;

        $setMethod = new MethodGenerator($methodName);
        $setMethod->addFlag(MethodGenerator::FLAG_PUBLIC);
        $setMethod->setParameter(
            new ParameterGenerator($name, null, $defaultValue)
        );
        $setMethod->setDocBlock(
            new DocBlockGenerator(
                'Set ' . $name,
                null,
                array(
                    array(
                        'name'        => 'param',
                        'description' => $attributes['type'] . ' $' . $name,
                    )
                )
            )
        );
        $setMethod->setBody(
            '$this->' . $name . ' = $' . $name . ';'
        );

        return $setMethod;
    }
}
