<?php

namespace OpenCardPMG\Checkers;


class OpenCardChecker extends DefaultChecker
{
    public static function execute()
    {
        $plugin_name = isset( $_ENV['PLUGIN_NAME'] )?$_ENV['PLUGIN_NAME']:'OpenCart Payments Gateway';
        $needed_version_min = isset( $_ENV['OPENCART_VERSION_MIN'] )?$_ENV['OPENCART_VERSION_MIN']:'';
        $needed_version_max = isset( $_ENV['OPENCART_VERSION_MAX'] )?$_ENV['OPENCART_VERSION_MAX']:'';
        $current_version = VERSION;

        if( empty( $needed_version_min ) || empty( $needed_version_max ) || empty( $current_version ) ) return true;

        if ( version_compare( $current_version, $needed_version_min, '<' ) ){
            $message = sprintf( '%s requires OpenCart version more than %s. Please, update your site.', $plugin_name, $needed_version_min );
            self::put_message( $message );
            return false;
        }

        if ( version_compare( $current_version, $needed_version_max, '>' ) ){
            $message = sprintf( '%s requires OpenCart version less than %s. Please, use another our plugin which compatibles with your OpenCard.', $plugin_name, $needed_version_max );
            self::put_message( $message );
            return false;
        }

        return true;
    }
}