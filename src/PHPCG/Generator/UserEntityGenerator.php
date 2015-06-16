<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Generator;

use Zend\Code\Generator\BodyGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag\GenericTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\ValueGenerator;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\FileReflection;
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
     * Load class from reflection
     *
     * @param $fileName
     */
    public function loadClass($fileName)
    {
        $fileReflection = new FileReflection($fileName, true);
        $classReflection = $fileReflection->getClass('User\Entity\UserEntity');
        $oldClass = ClassGenerator::fromReflection($classReflection);

        $properties = $oldClass->getProperties();
        $methods    = $oldClass->getMethods();

        /** @var PropertyGenerator $property */
        foreach ($properties as $name => $property) {
            /** @var GenericTag $tag */
            foreach ($property->getDocBlock()->getTags() as $tag) {
                if ($tag->getName() == 'generated' && $tag->getContent() == 'automatic') {
                    unset($properties[$name]);

                    $getMethodName = strtolower('get' . $this->filterUnderscoreToCamelCase->filter($name));

                    if (isset($methods[$getMethodName])) {
                        unset($methods[$getMethodName]);
                    }

                    $setMethodName = strtolower('set' . $this->filterUnderscoreToCamelCase->filter($name));

                    if (isset($methods[$setMethodName])) {
                        unset($methods[$setMethodName]);
                    }
                }
            }
        }

        $this->createClass();
        $this->class->addProperties($properties);
        $this->class->addMethods($methods);
    }

    /**
     * Add properties to entity class
     *
     * @param array $columns
     * @param bool  $validation
     */
    public function addEntityProperties(array $columns = array(), $validation = false)
    {
        foreach ($columns as $name => $attributes) {
            $property  = $this->generateProperty($name, $attributes);
            $getMethod = $this->generateGetMethod($name, $attributes);
            $setMethod = $this->generateSetMethod($name, $attributes, $validation);

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
                    ),
                    array(
                        'name'        => 'generated',
                        'description' => 'automatic',
                    ),
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
                    ),
                    array(
                        'name'        => 'generated',
                        'description' => 'automatic',
                    ),
                )
            )
        );
        $getMethod->setBody('return $this->' . $name . ';');

        return $getMethod;
    }

    /**
     * @param string $name
     * @param array  $attributes
     * @param bool   $validation
     *
     * @return MethodGenerator
     */
    private function generateSetMethod($name, array $attributes = array(), $validation = false)
    {
        $methodName   = 'set' . $this->filterUnderscoreToCamelCase->filter($name);
        $defaultValue = !$attributes['required'] ? new ValueGenerator(null) : null;

        $body = '';

        if ($validation) {
            if ($attributes['type'] == 'integer') {
                $body.= 'if (!is_int($' . $name . ')) {' . "\n";
                $body.= '    throw new \InvalidArgumentException(\'Not an integer\');' . "\n";
                $body.= '}' . "\n";
            } elseif ($attributes['type'] == 'string' && isset($attributes['max_length'])) {
                $body.= 'if (strlen($' . $name . ') > ' . $attributes['max_length'] . ') {' . "\n";
                $body.= '    throw new \InvalidArgumentException(\'String to long\');' . "\n";
                $body.= '}' . "\n";
            } elseif ($attributes['type'] == 'string' && isset($attributes['values'])) {
                $body.= 'if (!in_array($' . $name . ', array(\'' . implode('\',\'', $attributes['values']) . '\'))) {' . "\n";
                $body.= '    throw new \InvalidArgumentException(\'Invalid value\');' . "\n";
                $body.= '}' . "\n";
            }
        }

        $body .= '$this->' . $name . ' = $' . $name . ';';

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
                    ),
                    array(
                        'name'        => 'generated',
                        'description' => 'automatic',
                    ),
                )
            )
        );
        $setMethod->setBody($body);

        return $setMethod;
    }
}
