<?php
/**
 * Class for analysing server HOST and loading environment variables from .env files
 */

namespace OpenCardPMG\DotEnv;

use OpenCardPMG\Helper\CoreHelper;

class DotEnv
{
    const ENV_LOCAL     = 'local';
    const ENV_DEV       = 'dev';
    const ENV_STAGE     = 'stage';
    const ENV_PREPROD   = 'preprod';
    const ENV_PROD      = 'prod';

    private $environment        = self::ENV_LOCAL;

    /**
     * automatically analyses environment and loads environment variables from conf. files
     */
    public function __construct( ){
        $this->environment = $this->getEnvironment();

        $this->setDataToGlobalVar( 'ENV', $this->environment );
        $this->loadConfigData( 'env.'.$this->environment.'.php' );
        $this->loadConfigData( 'env.php' );
    }

    /**
     * method for getting info about ENVIRONMENT which we have on the server
     * @return string
     */
    private function getEnvironment(){

        $host = isset($_SERVER['HTTP_HOST'])?trim( $_SERVER['HTTP_HOST'] ):'localhost';

        // check if local environment
        $host_array = explode( '.',$host );
        $count_elements = count( $host_array );
        if( $count_elements < 2 || $host_array[ --$count_elements ] == 'loc' || $host == '127.0.0.1' ){
            return self::ENV_LOCAL;
        }

        // check if domain has name STAGE - we are using STAGE environment
        if( strpos( $host, 'stage' ) !== false  ){
            return self::ENV_STAGE;
        }

        // check if domain has name PREPROD - we are using PREPROD environment
        if( strpos( $host, 'preprod' ) !== false  ){
            return self::ENV_PREPROD;
        }

        // check if domain has name DEV - we are using DEV environment
        if( strpos( $host, 'dev' ) !== false  ){
            return self::ENV_DEV;
        }

        // in another case - we`ll use PROD mode
        return self::ENV_PROD;
    }


    /**
     * Method for loading configuration data from config file and putting them to global variables and env
     * @param string $filename - allowed JUST .env, .env.prod, .env.stage, etc
     * @return bool - the result of importing config data
     */
    private function loadConfigData( $filename ){
        // check filename with config. ALLOWED JUST .env, .env.prod, .env.stage, etc
        if( preg_match( '/(^env\.|$)/', $filename ) === false ){
            return false;
        }

        $base_dir = CoreHelper::get_project_path();
        $file = $base_dir.$filename;
        if( !file_exists( $file ) ) {
            return false;
        }
        $lines = file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = $this->parseConfigLine( $line );
            if( $data === false ){
                continue;
            }

            list($name, $value) = $data;
            $this->setDataToGlobalVar( $name, $value );
        }

        return true;
    }

    /**
     * method parse data from config files
     * @param $line
     * @return array|false
     */
    private function parseConfigLine( $line ){
        if ( strpos( trim($line), '#') === 0
            ||
            strpos( $line, '=') === false ) {
            return false;
        }

        list($name, $value) = explode('=', $line, 2);

        preg_match( '/(^[^#]+)/', $value, $matches );
        if( !is_array( $matches ) || count( $matches ) < 2 ){
            return false;
        }

        $name = trim($name);
        $value = trim($matches[1]);
        return [ $name, $value ];
    }

    /**
     * method which puts any data to the global variables $_SERVER, $_ENV
     * @param $name - variables name
     * @param $value - variables value
     * @param $force -  rewrite if we already have variable
     * @return void
     */
    private function setDataToGlobalVar( $name, $value, $force = false ){
        if ( ( !array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV) )
            || $force === true
        ) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}
