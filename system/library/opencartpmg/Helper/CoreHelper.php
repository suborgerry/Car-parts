<?php

/**
 * class with static methods which help us to get/set/decorate some data
 */

namespace OpenCardPMG\Helper;

class CoreHelper
{
    const DEFAULT_PROJECT_PATH = DIR_APPLICATION.'../system/library/opencartpmg/';

    public static function get_project_path(){
        return self::DEFAULT_PROJECT_PATH;
    }

    /**
     * method for getting modules name
     * @return string
     */
    public static function get_module_name(){
        $module = isset( $_ENV['PLUGIN_NAME'] )?ucfirst($_ENV['PLUGIN_NAME']):'PaymentPMG';
        return $module;
    }

    /**
     * method for getting modules short name
     * @return string
     */
    public static function get_module_short_info( $lang = false ){
        switch ( $lang ){
            case 'lv':
                return isset( $_ENV['PLUGIN_SHORTINFO_LV'] )?ucfirst($_ENV['PLUGIN_SHORTINFO_LV']):'Maksājiet ar Visa / MasterCard';
            case 'ru':
                return isset( $_ENV['PLUGIN_SHORTINFO'] )?ucfirst($_ENV['PLUGIN_SHORTINFO']):'Оплата Visa / MasterСard';
            case 'en':
            default:
                return isset( $_ENV['PLUGIN_SHORTINFO'] )?ucfirst($_ENV['PLUGIN_SHORTINFO']):'Pay with Visa / MasterCard';
        }
    }

    /**
     * method for getting basic module url
     * @return string
     */
    public static function get_basic_module_url(){
        return 'extension/payment/opencartpmg';
    }

    /**
     * method for basic module language path
     * @return string
     */
    public static function get_language_path(){
        return 'extension/payment/opencartpmg';
    }

    /**
     * method for getting info about payment system API gate URL
     * @return string
     */
    public static function get_gate(){
        $re = '/\/$/m';
        $gate = isset( $_ENV['GATE'] )?$_ENV['GATE']:'https://some.gate';
        return preg_replace($re, '', $gate);
    }

    /**
     * method for clearing double slashes URL
     * @return string
     */
    public static function clear_URL( $url ){
        return str_replace( '//', '/', $url );
    }

    /**
     * method for getting info about current modules version
     * @return string
     */
    public static function get_module_version(){
        return isset( $_ENV['OPENCART_VERSION_MIN'] )?$_ENV['OPENCART_VERSION_MIN']:'v3.0.0';
    }

    /**
     * method which gets current payment API version
     * @return string
     */
    public static function get_payment_api_version(){
        return isset( $_ENV['PAYMENT_API_VERSION'] )?$_ENV['PAYMENT_API_VERSION']:'v0.6';
    }

    /**
     * method for getting current OpenCart version
     * @return mixed
     */
    public static function get_opencart_version(){
        return VERSION;
    }

    /**
     * method for getting current OpenCart version
     * @return mixed
     */
    public static function get_opencart_major_version() {
        return substr(VERSION, 0, 1);
    }

    /**
     * method return message about system configuration
     * @return string
     */
    public static function generate_init_message(){
        return 'OpenCart ver.:'.VERSION.', PHP ver.: '.phpversion();
    }

    /**
     * method with message to LOG file about customer connection
     * @return mixed|string
     */
    public static function generate_customer_data(){
        return isset( $_SERVER['HTTP_USER_AGENT'] )?$_SERVER['HTTP_USER_AGENT']:'';
    }


    /**
     * method return message about system configuration
     * @return string
     */
    public static function generate_init_log_message(){
        return 'OpenCart ver.:'.self::get_opencart_version().', PHP ver.: '.phpversion();
    }

    /**
     * method with message to LOG file about customer connection
     * @return mixed|string
     */
    public static function generate_customer_log_data(){
        return isset( $_SERVER['HTTP_USER_AGENT'] )?$_SERVER['HTTP_USER_AGENT']:'';
    }

    /**
     * method with general info about customers order
     * @param $order
     * @return false|string
     */
    public static function generate_order_log_data( $order ){
        if( !is_array( $order ) ){
            return false;
        }

        return 'ID order: '.$order['order_id']
            .', total price: '.$order['total'].' '.$order['currency_code']
            .', commission: '.(isset($order['commission'])?$order['commission']:0).' '.$order['currency_code']
            .', currency_value: '.$order['currency_value']
            .', user_agent: '.$order['user_agent'];
    }

    /**
     * methid which gets message which will be added to transaction for admin side
     * @return string
     */
    public static function get_dms_note_for_transaction(){
        $order_note = isset( $_ENV['MESSAGE_DMS'] )?$_ENV['MESSAGE_DMS']:'';
        $link = isset( $_ENV['GATE'] )?$_ENV['GATE']:'';
        return str_replace( '%cabinet%', '<a target="_blank" href="'.$link.'">cabinet</a>', $order_note );
    }

    public static function get_url_user_token( $session, $as_array = false ){
        if ( !empty( VERSION )
            && version_compare( VERSION, 3, '<' ) ) {
            return ( !$as_array ?  'token=' . $session->data['token'] : array( 'token'=>$session->data['token'] ) );
        }
        return ( !$as_array ?  'user_token=' . $session->data['user_token'] : array( 'token'=>$session->data['user_token'] ) );
    }

    public static function get_url_marketplace( ){
        if ( !empty( VERSION )
            && version_compare( VERSION, 3, '<' ) ) {
            return 'extension/extension';
        }
        return 'marketplace/extension';
    }
}