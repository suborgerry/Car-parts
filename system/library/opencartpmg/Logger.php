<?php

/**
 * class Logger
 * uses default logger from OpenCard - Log
 * has methods for writing NOTICE, WARNING, ERROR messages to the log of the plugin
 */
namespace OpenCardPMG;

Class Logger {

    private $enabled = false;
    private $vendor = false;
    private $plugin_id = false;
    private $api_rev = false;
    private $logger = false;
    private $order_id = false;

    public function __construct($enabled = true) {
        $this->enabled = $enabled;
        $this->plugin_id = OpenCartPMGAPI::get_plugin_id();
        $this->vendor = OpenCartPMGAPI::get_plugin_name();
        $this->api_rev = OpenCartPMGAPI::get_payments_module_ver();
        $this->logger = new \Log( $this->plugin_id.'.log' );
    }

    /**
     * SET Order ID
     * @param $id_order
     * @return void
     */
    public function set_order_id( $id_order = false ){
        $this->order_id = intval( $id_order );
    }

    /**
     * get order ID
     * @return bool
     */
    public function get_order_id( ){
        return $this->order_id;
    }

    /**
     * method for getting is enabled functional for logging to the plugin .log file
     * @return bool
     */
    public function get_is_enabled(){
        return $this->enabled;
    }

    /**
     * method for adding brake line ( for splitting important messages )
     * @return void
     */
    public function add_brake_line(){
        $this->logger->write( '----------------------------------------------------------------------' );
    }

    /**
     * method for writing NOTICE mesagges to the .log file
     * @param $message
     * @return void
     */
    public function info( $message ){
        if( $this->enabled === false ) return;

        $order_message = '';
        if( !empty( $this->order_id ) ) $order_message .= ', Order #'.intval( $this->order_id );
        $this->logger->write( 'INFO, '.$this->vendor.' ('.$this->api_rev.')'.$order_message.': '.$message);
    }

    /**
     * method for writing WARNING messages to the .log file
     * @param $message
     * @return void
     */
    public function warning( $message ){
        if( $this->enabled === false ) return;

        $order_message = '';
        if( !empty( $this->order_id ) ) $order_message .= ', Order #'.intval( $this->order_id );
        $this->logger->write( 'WARNING, '.$this->vendor.' ('.$this->api_rev.')'.$order_message.': '.$message);
    }

    /**
     * method for writing ERROR messages to the .log file
     * @param $message
     * @return void
     */
    public function error( $message ){
        if( $this->enabled === false ) return;

        $order_message = '';
        if( !empty( $this->order_id ) ) $order_message .= ', Order #'.intval( $this->order_id );
        $this->logger->write( 'ERROR, '.$this->vendor.' ('.$this->api_rev.')'.$order_message.': '. $message);
    }
}