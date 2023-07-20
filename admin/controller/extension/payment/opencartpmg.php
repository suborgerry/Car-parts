<?php

use OpenCardPMG\Helper\CoreHelper;

require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');

/**
 *  class for admin area which uses for configuring OpenPMG module
 */
class ControllerExtensionPaymentOpenCartPMG extends Controller {

    private $error = array();

    public function __construct($registry)
    {
        \OpenCardPMG\OpenCartPMG::init_core();
        parent::__construct($registry);
    }

    /**
     * method which processes edit page in OpenPMG module
     * @return void
     */
    public function index() {
        $this->load->language( CoreHelper::get_language_path() );

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        // check requirements and show message if we have issue with it
        $this->check_capabilities();

        //save configuration for the module
        if ( $this->request->server['REQUEST_METHOD'] == 'POST'
            && $this->validate()
        ) {

            $data_for_save = $this->request->post;
            array_walk( $this->request->post, function( $item, $key ) use ( &$data_for_save ) {
                $data_for_save[ 'payment_'.$key ] = $item;
            } );
            $this->model_setting_setting->editSetting('opencartpmg', $data_for_save );
            $this->model_setting_setting->editSetting('payment_opencartpmg', $data_for_save );

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link( CoreHelper::get_url_marketplace(), CoreHelper::get_url_user_token( $this->session ) . '&type=payment', true));
        }

        //set up default statuses when we load configuration page first time
        $this->change_default_statuses();

        //fill info for configuration view
        $data = array();
        foreach( $this->error as $key=>$value ){
            $data[ $key ] = $value;
        }

        $data['language'] = $this->language;
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_home') ,
          'href' => $this->url->link('common/dashboard', CoreHelper::get_url_user_token( $this->session ), true) ,
          'separator' => false
        );
        $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_payment') ,
          'href' => $this->url->link( CoreHelper::get_url_marketplace(), CoreHelper::get_url_user_token( $this->session ) . '&type=payment', true) ,
          'separator' => ' :: '
        );
        $data['breadcrumbs'][] = array(
          'text' => $this->language->get('heading_title') ,
          'href' => $this->url->link( CoreHelper::get_basic_module_url(), CoreHelper::get_url_user_token( $this->session ), true) ,
          'separator' => ' :: '
        );
        $data['action'] = $this->url->link( CoreHelper::get_basic_module_url(), CoreHelper::get_url_user_token( $this->session ), true);
        $data['cancel'] = $this->url->link( CoreHelper::get_url_marketplace(), CoreHelper::get_url_user_token( $this->session ) . '&type=payment', true);

        // load model localisation/order_status for gettin allowed statuses for customers orders
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $arr = array(
          "opencartpmg_public_key",
          "opencartpmg_private_key",
          "opencartpmg_iframe",
          "opencartpmg_status",
          "opencartpmg_pending_status_id",
          "opencartpmg_completed_status_id",
          "opencartpmg_failed_status_id",
          "opencartpmg_sort_order",
        );
        foreach($arr as $v) {
          $data[$v] = (isset($this->request->post[$v])) ? $this->request->post[$v] : $this->config->get($v);
        }

        // prepare authorization tocken for admin session
        $token = CoreHelper::get_url_user_token( $this->session, true );
        $data = array_merge( $data, $token );

        // prepare view and show it
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view( CoreHelper::get_basic_module_url(), $data));
    }

    /**
     * method for setting default values for order statuses then we load configuration form first time
     * @return void
     */
    private function change_default_statuses(){
        if( empty( $this->config->get('opencartpmg_pending_status_id') )
            && empty( $this->config->get('opencartpmg_failed_status_id') )
            && empty( $this->config->get('opencartpmg_completed_status_id') )
        ){
            $this->config->set('opencartpmg_pending_status_id', '1');
            $this->config->set('opencartpmg_failed_status_id', '10');
            $this->config->set('opencartpmg_completed_status_id', '5');
        }
    }

    /**
     * method which validate filled in admins info
     * @return bool
     */
    private function validate() {
        if (!$this->user->hasPermission('modify', CoreHelper::get_basic_module_url() ) ) {
          $this->error['error_opencartpmg_warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['opencartpmg_public_key']) {
          $this->error['error_opencartpmg_public_key'] = $this->language->get('error_public_key');
        }

        if (!$this->request->post['opencartpmg_private_key']) {
          $this->error['error_opencartpmg_private_key'] = $this->language->get('error_private_key');
        }

        return !count( $this->error );
    }

    /**
     * method for checking capabilities for this module
     * @return void
     */
    private function check_capabilities(){
        \OpenCardPMG\Checkers\CapabilityChecker::execute();
        \OpenCardPMG\Checkers\OpenCardChecker::execute();
        $messages = \OpenCardPMG\Checkers\DefaultChecker::get_messages();
        if( count( $messages ) ){
            $this->error['error_capabilities'] = $messages;
        }
    }
}
