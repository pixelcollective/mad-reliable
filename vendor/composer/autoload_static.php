<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4f3d454bc1aa0e693e9423f6089979e4
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TPC\\Uptime\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TPC\\Uptime\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4f3d454bc1aa0e693e9423f6089979e4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4f3d454bc1aa0e693e9423f6089979e4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}