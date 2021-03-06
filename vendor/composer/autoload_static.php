<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit54912709fd7cf09a3381abac1d47a474
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit54912709fd7cf09a3381abac1d47a474::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit54912709fd7cf09a3381abac1d47a474::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
