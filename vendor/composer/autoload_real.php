<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf55b1bbe960cdbc5c8b9b5f5a8c745cb
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitf55b1bbe960cdbc5c8b9b5f5a8c745cb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf55b1bbe960cdbc5c8b9b5f5a8c745cb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf55b1bbe960cdbc5c8b9b5f5a8c745cb::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInitf55b1bbe960cdbc5c8b9b5f5a8c745cb::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequiref55b1bbe960cdbc5c8b9b5f5a8c745cb($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequiref55b1bbe960cdbc5c8b9b5f5a8c745cb($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}