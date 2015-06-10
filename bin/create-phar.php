#!/usr/bin/env php
<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

// define application root
define('DWX2015_PHPCG_ROOT', realpath(__DIR__ . '/..'));

// define file and path
$filename  = 'phpcg.phar';
$pharPath = DWX2015_PHPCG_ROOT . '/' . $filename;

// unlink phar if exists
if (file_exists($pharPath)) {
    unlink($pharPath);
}

// create phar and add files
$phar = new \Phar($pharPath, 0, $filename);
$phar->startBuffering();
$phar->addFromString(
    DWX2015_PHPCG_ROOT . '/bin/phpcg.php',
    substr(php_strip_whitespace(DWX2015_PHPCG_ROOT . '/bin/phpcg.php'), 19)
);

addDir($phar, DWX2015_PHPCG_ROOT . '/bin', DWX2015_PHPCG_ROOT);
addDir($phar, DWX2015_PHPCG_ROOT . '/config', DWX2015_PHPCG_ROOT);
addDir($phar, DWX2015_PHPCG_ROOT . '/src', DWX2015_PHPCG_ROOT);
addDir($phar, DWX2015_PHPCG_ROOT . '/vendor', DWX2015_PHPCG_ROOT);

$phar->setStub($phar->createDefaultStub('bin/phpcg.php'));
$phar->stopBuffering();

// stop processing
if (file_exists($pharPath)) {
    echo 'Phar created successfully in ' . $pharPath . "\n";
    chmod($pharPath, 0755);
} else {
    echo 'Error during the compile of the Phar file ' . $pharPath . "\n";
    exit(2);
}

/**
 * Add a directory in phar removing whitespaces from PHP source code
 *
 * @param Phar   $phar
 * @param string $sDir
 * @param null   $baseDir
 */
function addDir($phar, $sDir, $baseDir = null)
{
    $oDir = new RecursiveIteratorIterator (
        new RecursiveDirectoryIterator ($sDir),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($oDir as $sFile) {
        if (preg_match('/\\.(php|phtml)$/i', $sFile)) {
            addFile(
                $phar,
                $sFile,
                $baseDir
            );
        }
    }
}

/**
 * Add a file in phar removing whitespaces from the file
 *
 * @param Phar   $phar
 * @param string $sFile
 * @param null   $baseDir
 */
function addFile($phar, $sFile, $baseDir = null)
{
    if (null !== $baseDir) {
        $phar->addFromString(
            substr(
                $sFile, strlen($baseDir) + 1
            ),
            php_strip_whitespace($sFile)
        );
    } else {
        $phar->addFromString(
            $sFile,
            php_strip_whitespace($sFile)
        );
    }
}
