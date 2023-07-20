<?php

use OpenCardPMG\Helper\CoreHelper;
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');

/**
 *  class-controller for customers side. uses for:
 * - create request to the payment gateway
 * - validate customers payment
 * - show success/failure page
 */
class ControllerExtensionPaymentOpenCartPMG extends Controller
{
    /**
     * @var \OpenCardPMG\OpenCartPMGAPI
     */
    protected $openCartPMGAPI;

    /**
     * method for init basic configuration, enabling autoloader, connection to DotEnv
     * @param $arg
     */
    public function __construct($arg)
    {
        parent::__construct($arg);

        $this->private_key = ($this->config->get('opencartpmg_private_key'));
        $this->public_key = ($this->config->get('opencartpmg_public_key'));
        $this->iframe = ($this->config->get('opencartpmg_iframe'));

        \OpenCardPMG\OpenCartPMG::init_core();
        $this->openCartPMGAPI = new \OpenCardPMG\OpenCartPMGAPI( $this->private_key, $this->public_key, ( new \OpenCardPMG\Logger() ) );
        $this->language->load( CoreHelper::get_language_path() );
    }

    /**
     * method which works on the checkout page and creates order + request to the payment gateway
     * @return void
     */
    public function index()
    {
        $this->load->model('checkout/order');
        $this->language->load('payment/opencartpmg');

        // check info about order. if we don`t have it - we don`t process page
        if (!isset($this->session->data['order_id'])) {
            return;
        }
        $order_id = (string)$this->session->data['order_id'];
        $this->openCartPMGAPI->logger->set_order_id( $order_id );
        $this->document->setTitle($this->language->get('text_title'));

        // generate log data about customers payment request
        $init_message = CoreHelper::generate_init_log_message();
        $this->openCartPMGAPI->logger->add_brake_line();
        $this->openCartPMGAPI->logger->info( $init_message );

        $cust_info_message = CoreHelper::generate_customer_log_data();
        $this->openCartPMGAPI->logger->add_brake_line();
        $this->openCartPMGAPI->logger->info( $cust_info_message );

        // fill info for checkout page
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['token'] = true;
        $data['language'] = $this->language;
        $data['action'] = $this->url->link( CoreHelper::get_basic_module_url().'/confirm_order', '', 'SSL');

        // if admin enabled Iframe mode - we need to create payment request and show it on the checkout page
        if ($this->iframe) {
            try {
                $payment = $this->make_payment();

                $order_info = $this->model_checkout_order->getOrder($order_id);
                $data['payment_method'] = $order_info['payment_method'];

                if ( is_array( $payment ) && !empty( $payment ) ) {
                    $data['src'] = $payment['iframe_checkout'];
                }else{
                    throw new \Exception( 'The order was not created.' );
                }
                $this->openCartPMGAPI->logger->info( 'Init payment in Iframe ' );
            }catch ( Exception $e ){
                $this->openCartPMGAPI->logger->error( " {$e->getMessage()}, {$e->getFile()}:{$e->getLine()} " );

                // render failure view
                $data = [ 'url' => $this->url->link('checkout/failure', '', 'SSL') ];
                return $this->load->view( CoreHelper::get_basic_module_url(), $data);
            }
        } else {
            $data['redirect'] = true;
        }
//dd($data);
        return $this->load->view( CoreHelper::get_basic_module_url(), $data);
    }

    /**
     * method which will be run if we use full page payment page after checkout page
     * @return void
     */
    public function confirm_order()
    {
        try {
            $payment = $this->make_payment();
            if ( is_array( $payment ) && !empty( $payment ) ) {
                $this->response->redirect($payment['full_page_checkout']);
            }else{
                throw new \Exception( 'The order was not created.' );
            }
        }catch ( Exception $e ){
            $this->openCartPMGAPI->logger->error( " {$e->getMessage()}, {$e->getFile()}:{$e->getLine()} " );

            $this->response->redirect( $this->url->link('checkout/failure', '', 'SSL') );
        }
    }

    /**
     * method which processes failure answer from payment gateway
     * @return void
     */
    public function callback_failure()
    {
        $this->load->model('checkout/order');

        $order_id = $this->get_id_order();
        $payment_id = $this->get_id_payment();

        $this->openCartPMGAPI->logger->set_order_id( $order_id );
        $this->openCartPMGAPI->logger->warning('Loaded failure model.');

        $admin_message = $this->language->get('opencartpmg_order_status_failed');
        if( !empty( $payment_id ) ){
            $payment_info = $this->openCartPMGAPI->getPaymentInfo( $payment_id );
            if( isset( $payment_info['transaction_details'] )
                && isset( $payment_info['transaction_details']['errors'] )
                && is_array( $payment_info['transaction_details']['errors'] ) ){
                $errors = array_column( $payment_info['transaction_details']['errors'], 'description');

                //write to log info about transaction error messages
                $this->openCartPMGAPI->logger->error( "Transaction error messages - " . implode(', ', $errors) );

                //write to customer order info about transaction error messages
                $admin_message = 'Payment failed, error description: '.implode( ',', $errors );
            }
        }

        // change status for order
        $this->model_checkout_order->addOrderHistory(
            $order_id,
            $this->config->get('opencartpmg_failed_status_id'),
            $admin_message,
            false
        );

        $url = $this->url->link('checkout/failure', '', 'SSL');
        $this->openCartPMGAPI->logger->info($url);
        $data['url'] = $url;    

        return $this->response->setOutput($this->load->view( CoreHelper::get_basic_module_url() , $data));
    }

    /**
     * method which check transaction state and processes success page
     * @return void
     */
    public function callback_success()
    {
        $this->load->model('checkout/order');

        $order_id = $this->get_id_order();
        $payment_id = $this->get_id_payment();

        $this->openCartPMGAPI->logger->set_order_id( $order_id );
        $this->openCartPMGAPI->logger->warning('Loaded Success model.');

        $data = [];

        $success_message = '';
        if ($this->openCartPMGAPI->was_payment_successful( $order_id, $payment_id, $success_message )) {
            $this->model_checkout_order->addOrderHistory(
                $order_id,
                $this->config->get('opencartpmg_completed_status_id'),
                $success_message,
                false
            );
        } else {
            $this->openCartPMGAPI->logger->error('Could not verify payment, redirecting to failure page');
            $this->model_checkout_order->addOrderHistory(
                $order_id,
                $this->config->get('opencartpmg_failed_status_id'),
                $this->language->get('opencartpmg_order_status_failed'),
                false
            );
        }

        $url = $this->url->link('checkout/success', '', 'SSL');
        $this->openCartPMGAPI->logger->info($url);
        $data['url'] = $url; 

        return $this->response->setOutput($this->load->view( CoreHelper::get_basic_module_url(), $data));
    }

    /**
     * method for finding order id from different sources( cookie, session, $_get )
     * @return false|int|mixed
     */
    protected function get_id_order(){
        if( isset( $_COOKIE['order_id'] ) ){
            return $_COOKIE['order_id'];
        }elseif ( isset( $this->session->data['order_id'] ) ) {
            return $this->session->data['order_id'];
        }elseif( !empty( $_GET['order_id'] ) ){
            return intval( $_GET['order_id'] );
        }
        return false;
    }

    /**
     * method for finding payment id from different sources( cookie, session, $_get )
     * @return false|mixed
     */
    protected function get_id_payment(){
        $this->load->model('checkout/order');

        if( isset( $_COOKIE['payment_id'] ) ){
            return $_COOKIE['payment_id'];
        }elseif ( isset( $this->session->data['payment_id'] ) ) {
            return $this->session->data['payment_id'];
        }elseif( $this->get_id_order() ){
            $order_id = $this->get_id_order();
            $order_info = $this->model_checkout_order->getOrder($order_id);
            if( is_array( $order_info )
                && count( $order_info )
                && isset( $order_info['payment_custom_field'] )
                && isset( $order_info['payment_custom_field']['payment_id'] )){
                return $order_info['payment_custom_field']['payment_id'];
            }
        }
        return false;
    }

    /**
     * method for processing customer request from site, create customers card / request for payment on the gateway side
     * @return mixed|void
     * @throws Exception
     */
    protected function make_payment()
    {
        $this->load->model('checkout/order');

        // In case there is no order, do nothing
        if (!isset($this->session->data['order_id'])) {
            return;
        }

        $order_id = (string)$this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $order_info['total'] = $this->currency->format($order_info['total'], $this->session->data['currency'], '', false);

        if( !is_array( $order_info ) || empty( $order_info ) ){
            throw new \Exception( "NOT found info about order #{$order_id} in OpenCart." );
        }

        //write log data about customers order
        $order_info_message = CoreHelper::generate_order_log_data( $order_info );
        $this->openCartPMGAPI->logger->set_order_id( $order_id );
        $this->openCartPMGAPI->logger->add_brake_line();
        $this->openCartPMGAPI->logger->info( $order_info_message );
        $this->openCartPMGAPI->logger->add_brake_line();

        $this->model_checkout_order->addOrderHistory(
            (string)$order_id,
            $this->config->get('opencartpmg_pending_status_id'),
            'Ordering',
            false
        );

        $language = $this->_language( $this->session->data['language'] );
        $successUrl = $this->url->link( CoreHelper::get_basic_module_url().'/callback_success&id='.$order_id, '', 'SSL');
        $failureUrl = $this->url->link( CoreHelper::get_basic_module_url().'/callback_failure&id='.$order_id, '', 'SSL');

        $payment = $this->openCartPMGAPI->create_payment( $order_info, $language, $successUrl, $failureUrl );
        if ($payment) {
            // if payment request was created - change order status + fill info about it to session/cookie
            $this->model_checkout_order->addOrderHistory(
                (string)$order_id,
                $this->config->get('opencartpmg_pending_status_id'),
                $this->language->get('opencartpmg_order_status_pending'),
                false
            );

            // write info about order and transaction id to the clients order
            $message = 'Order ID: '.$payment['id'].'; ';
            if( isset( $payment['transaction_details'] )
                && isset( $payment['transaction_details']['transactions_id'] )  ){
                $message .= 'Transaction ID: '.$payment['transaction_details']['transactions_id'].'; ';
            }
            $this->model_checkout_order->addOrderHistory(
                (string)$order_id,
                $this->config->get('opencartpmg_pending_status_id'),
                $message,
                false
            );

            $set = 'Set-Cookie: payment_id=' . $payment['id'] . '; SameSite=None; Secure';
            header($set, false);
            $set = 'Set-Cookie: order_id=' . $order_id . '; SameSite=None; Secure';
            header($set, false);

            $this->session->data['payment_id'] = $payment['id'];

            $order_info['customer_group_id'] = 0;
            $order_info['payment_custom_field'] = ['payment_id'=>$payment['id']];
            $this->model_checkout_order->editOrder( $order_id, $order_info);

            $this->openCartPMGAPI->logger->info('Payment was created successfully: ' . $payment['id'] . ', order #' . $order_id);
        } else {
            throw new \Exception("The payment request for #{$order_id} was not created.");
        }

        return $payment;
    }

    /**
     * @param $lang_id
     * @return string
     */
    private function _language($lang_id)
    {
        $languages = array('en', 'ru', 'lv', 'lt', 'la'); // 'lv' and 'la' using for latvian lang
        $lang_id = strtolower(substr($lang_id, 0, 2));
        if (in_array($lang_id, $languages)) {
            return $lang_id;
        } else {
            return 'en';
        }
    }
}
