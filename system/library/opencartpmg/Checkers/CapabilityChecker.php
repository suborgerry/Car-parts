<?php

/**
 * class checks capabilities with different modules, depencies, etc
 */
namespace OpenCardPMG\Checkers;

class CapabilityChecker extends DefaultChecker
{

    public static function execute()
    {
        $plugin_name = isset( $_ENV['PLUGIN_NAME'] )?$_ENV['PLUGIN_NAME']:'OpenCart Payments Gateway';
        $needed_version = isset( $_ENV['PHP_VERSION_MIN'] )?$_ENV['PHP_VERSION_MIN']:'5.6';
        if( version_compare( phpversion(), $needed_version, '<' ) ){
            $message = sprintf( '%s requires PHP version more than %s. ', $plugin_name, $needed_version );
            self::put_message( $message );
            return false;
        }
        return true;
    }
}