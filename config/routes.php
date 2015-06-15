<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

return array(
    array(
        'name'              => 'hello-world',
        'route'             => 'hello-world',
        'description'       => 'Say hello to the world',
        'short_description' => 'Hello world',
        'handler'           => 'PHPCG\Command\HelloWorld',
    ),
    array(
        'name'                 => 'hello-you',
        'route'                => 'hello-you <you>',
        'description'          => 'Say hello to you',
        'short_description'    => 'Hello you',
        'options_descriptions' => array(
            '<you>' => 'Your name'
        ),
        'handler'              => 'PHPCG\Command\HelloYou',
    ),
    array(
        'name'              => 'hello-someone',
        'route'             => 'hello-someone',
        'description'       => 'Say hello to someone',
        'short_description' => 'Hello someone',
        'handler'           => 'PHPCG\Command\HelloSomeOne',
    ),
    array(
        'name'              => 'create-hello-you-class',
        'route'             => 'create-hello-you-class',
        'description'       => 'Create a hello you class',
        'short_description' => 'Create hello you class',
        'handler'           => 'PHPCG\Command\CreateHelloYouClass',
    ),
    array(
        'name'              => 'create-user-entities',
        'route'             => 'create-user-entities',
        'description'       => 'Create all user entities for database',
        'short_description' => 'Create user entities',
        'handler'           => 'PHPCG\Command\CreateUserEntities',
    ),
);
