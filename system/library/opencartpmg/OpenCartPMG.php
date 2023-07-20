<?php

/**
 * main class of the plugin
 * extends on teh OpenCart Payment Gateway and realises/rewrites some methods from this class. Also
 */
namespace OpenCardPMG;

use OpenCardPMG\DotEnv\DotEnv;

class OpenCartPMG
{
    /**
     * method for init core of module
     * @return void
     */
    public static function init_core(){
        self::init_autoload();
        new DotEnv();
        self::init_dev_helpers();
    }

    /**
     * method for autoload init.
     * @return void
     */
    private static function init_autoload(){
        spl_autoload_register( function ( $class ) {
            list( $plugin_space ) = explode( '\\', $class );
            if ( $plugin_space !== 'OpenCardPMG' ) {
                return;
            }

            // Default directory for all code is plugin's /src/.
            $plugin_dir = basename( __DIR__ );
            $base_dir = DIR_APPLICATION.'../system/library/opencartpmg/';

            // Get the relative class name.
            $relative_class = substr( $class, strlen( $plugin_space ) + 1 );
            $relative_class = str_replace('\\', '/', $relative_class);

            // Prepare a path to a file.
            $file = ( $base_dir . $relative_class . '.php' );

            // If the file exists, require it.
            if ( is_readable( $file ) ) {
                require_once $file;
            }
        } );
    }

    /**
     * method for init developers methods
     * @return mixed|string
     */
    private static function init_dev_helpers(){
        require_once DIR_APPLICATION.'../system/library/opencartpmg/devHelpers.php';
    }
}