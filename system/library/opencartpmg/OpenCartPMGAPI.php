<?php
/**
 * class for processing/handling payment requests, communicate with pyment API, create Iframe if needed
 */
namespace OpenCardPMG;

use OpenCardPMG\Helper\CoreHelper;

class OpenCartPMGAPI
{
    private $private_key            = false;
    private $public_key             = false;

    /**
     * @var Logger
     */
    public $logger             = false;


    public function __construct($private_key, $public_key, $logger){
        $this->private_key = $private_key;
        $this->public_key = $public_key;
        $this->logger = $logger;
    }


    /**
     * method for getting current version of our plugin from ENV data
     * @return string
     */
    public static function get_payments_module_ver(){
        return isset( $_ENV['PAYMENTS_MODULE_VERSION'] )?$_ENV['PAYMENTS_MODULE_VERSION']:'v2.0';
    }


    /**
     * method for getting current version of API payment system version from ENV data
     * @return string
     */
    public static function get_payments_api_ver(){
        return isset( $_ENV['PAYMENT_API_VERSION'] )?$_ENV['PAYMENT_API_VERSION']:'v0.6';
    }

    /**
     * method for getting plugin id
     * @return mixed|string
     */
    public static function get_plugin_id(){
        return isset( $_ENV['PLUGIN_ID'] )?$_ENV['PLUGIN_ID']:'payments_pmg';
    }

    /**
     * method for getting plugin name from ENV
     * @return mixed|string
     */
    public static function get_plugin_name(){
        return isset( $_ENV['PLUGIN_NAME'] )?$_ENV['PLUGIN_NAME']:'PaymentsGateway';
    }

    /**
     * method for getting GATE URL for processing payment from ENV data
     * @return mixed|string
     */
    public static function get_gate_url(){
        return isset( $_ENV['GATE'] )?$_ENV['GATE']:'';
    }


    /**
     * method for creating new payment request from customers order
     * @param $params
     * @return mixed|null
     */
    public function create_payment( $order, $language, $success_url, $failure_url ){
        $params = array(
            'number' => $order['order_id'],
            'referrer' => 'opencart module ' . CoreHelper::get_module_version(),
            'language' => $language,
            'success_redirect' => $success_url,
            'failure_redirect' => $failure_url,
            'currency' => $order['currency_code']
        );

        $this->add_user_data($order, $params);
        $this->add_products($order, $params);

        $this->logger->info( "Dump of data for new payment request: " . json_encode($params['products']) );

        return $this->create_order($params);
    }

    /**
     * method for checking current or create new customers card in API for processing order
     * @param $order
     * @param $params
     * @return void
     * @throws Exception
     */
    protected function add_user_data($order, &$params)
    {
        $user_data = [
            'email' => $order['email'],
            'first_name' => $order['payment_firstname'],
            'last_name' => $order['payment_lastname'],
            'phone' => $order['telephone'],
            'send_to_email' => true,
        ];

        $this->logger->info( 'Find customer by the email, phone - '.$user_data['email'].', '.$user_data['phone'] );
        $findUser = $this->get_user($user_data['email'], $user_data['phone']);
        if ( $findUser === null ) {
            $this->logger->info( 'The customer wasn`t found. Create new customers card.' );
            if ($this->create_user($user_data)) {
                $findUser = $this->get_user($user_data['email'], $user_data['phone']);
            }
        }

        if( !is_array( $findUser ) || !isset( $findUser['id'] ) ){
            throw new \Exception( 'Couldn`t create customer, please try later.' );
        }

        $this->logger->info( 'The customers ID - '.$findUser['id'] );
        $user_data['original_client'] = $findUser['id'];
        $params['client'] = $user_data;
    }


    /**
     * method for finding customers card in the payment system
     * @param $filter_email
     * @param $filter_phone
     * @return array|null
     */
    public function get_user( $filter_email, $filter_phone ){
        $this->logger->info( sprintf("Finding customers card in the payment system" ) );

        $params['filter_email'] = trim( $filter_email );
        $params['filter_phone'] = $this->transform_phone($filter_phone);
        $users = $this->call('GET', '/api/'.$this->get_payments_api_ver().'/clients/', $params);

        $this->logger->info( "Find user request params: " . json_encode($params));
        $this->logger->info("Find user response: " . json_encode($users));

        return isset( $users['results'] ) && isset( $users['results'][0] ) ? $users['results'][0] : null;
    }


    /**
     * method for creating new customers card in the payment system
     * @param $params
     * @return mixed|null
     */
    public function create_user($params){
        $params['phone'] = $this->transform_phone($params['phone']);
        $result = $this->call('POST', '/api/'.$this->get_payments_api_ver().'/clients/', $params);
        $this->logger->info("Create user request params: " . json_encode($params));

        if( empty( $result ) ){
            $this->logger->error("Create user response: " . json_encode($result, true));
        }else{
            $this->logger->info("Create user response: " . json_encode($result, true));
        }

        return $result;
    }

    /**
     * method for create one product with price the same like and summary price for order
     * @param $order - the object of WP customers order
     * @param $params - array of parameters which we need for create payment request
     * @return void
     */
    protected function add_products($order, &$params)
    {
        $title = 'Invoice for payment #';

        if ( $params['language'] === 'ru' ) {
            $title = 'Счет на оплату #';
        }elseif ( $params['language'] === 'lv' ) {
            $title = 'Maksājuma rēķins #';
        }

        $params['products'][] = [
            'price' => round( floatval( $order['total'] ), 2),
            'title' => $title . (string)$order['order_id'],
            'quantity' => 1
        ];
    }

    /**
     * method for create order in payment system(API)
     * @param $params
     * @return mixed|null
     */
    public function create_order($params)
    {
        $this->logger->info(sprintf("Loading payment form for order #%s", $params['number']));
        $result = $this->call('POST', '/api/'. CoreHelper::get_payment_api_version().'/orders/', $params);

        if ($result == null) {
            return null;
        }

        if (isset($result['full_page_checkout']) && isset($result['id'])) {
            $this->logger->info(sprintf("Form loaded successfully for order #%s", $params['number']));
            return $result;
        } else {
            return null;
        }
    }


    /**
     * method for checking customers payment.
     * @param $order_id
     * @param $payment_id
     * @return bool
     */
    public function was_payment_successful($order_id, $payment_id, &$success_message){
        $this->logger->info( sprintf("Validating payment for order #%s, payment #%s", $order_id, $payment_id) );

        $order_id = (string)$order_id;
        $result = $this->call('GET', sprintf('/api/'.$this->get_payments_api_ver().'/orders/%s/', $payment_id));
        if ( $result == null
            || !is_array( $result )
            || !isset( $result['number'] )
        ) {
            $this->logger->error( sprintf("The payment #%s was not found for the order #%s", $payment_id, $order_id ) );
            $this->logger->error("Get payment response: " . json_encode($result, true));
            return false;
        }

        if ( $order_id != (string)$result['number'] ) {
            $this->logger->error( "Got difference order ID from our system and payment request" );
            $this->logger->error( "Order ID - " . print_r($order_id, true) );
            $this->logger->error( "Order ID from response - " . print_r($result['number'], true) );
            $this->logger->error( "Get payment response - " . json_encode($result, true) );
            return false;
        }elseif(
            $result['status'] == 'paid'
            || $result['status'] == 'withdrawn'
        ) {
            $success_message = isset( $_ENV['MESSAGE_SUCCESS_TRANSACTION'] )?$_ENV['MESSAGE_SUCCESS_TRANSACTION']:'';
            $this->logger->info( sprintf("SUCCESS order #%s, payment #%s", $order_id, $payment_id) );
            return true;
        }elseif(
            $result['status'] == 'hold'
        ) {
            $success_message = CoreHelper::get_dms_note_for_transaction();
            $this->logger->info( sprintf("SUCCESS DMS order #%s, payment #%s", $order_id, $payment_id) );
            return true;
        } else {
            $this->logger->error( 'Could NOT validate payment' );
            $this->logger->error( "Order ID - " . print_r($order_id, true) );
            $this->logger->error( "Status - " . print_r($result['status'], true) );
            if( isset( $result['transaction_details'] )
                && isset( $result['transaction_details']['errors'] )
                && is_array( $result['transaction_details']['errors'] ) ){
                $messages = array_column($result['transaction_details']['errors'], 'description');
                $this->logger->error( "Transaction error messages - " . implode(', ', $messages) );
            }

            $this->logger->error( "Get payment response - " . json_encode($result, true) );
            return false;
        }
    }

    /**
     * method for getting info about payment
     * @param $payment_id
     * @return array|false
     */
    public function getPaymentInfo( $payment_id )
    {
        $result = $this->call('GET', sprintf('/api/'.CoreHelper::get_payment_api_version().'/orders/%s/', $payment_id));
        if ( $result == null
            || !is_array( $result )
            || !isset( $result['number'] )
        ) {
            return false;
        }

        return $result;
    }

    /**
     * MAIN method for making requests to the payment API
     * @param $method - allowed methods for REST API (  POST, PUT, GET, etc )
     * @param $route - API path for processing data
     * @param $params - additional params for the request to teh API
     * @return mixed|null
     */
    public function call( $method, $route, $params = array() ){
        $this->logger->info( sprintf("Init request to the payment gateway by method - #%s, url - %s", $method, CoreHelper::get_gate(). $route) );
        $original_params = $params;
        if (!empty($params)) {
            $params = json_encode($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, CoreHelper::get_gate(). $route);

        switch( $method ){
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_PUT, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
            case 'GET':
                $get_params = '';
                foreach ($original_params as $key => $value) {
                    $get_params .= $key . '=' . urlencode($value) . '&';
                }
                $get_params = trim($get_params, '&');
                curl_setopt($ch, CURLOPT_URL, CoreHelper::get_gate() . $route . '?' . $get_params);
                break;
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HTTP200ALIASES, (array)400);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/json',
            'Authorization: Bearer ' . $this->private_key
        ));

        $response = curl_exec($ch);
        if (!$response) {
            $this->logger->error("Got empty answer from API");
            $this->logger->error("Curl error - ".curl_error($ch));
        }

        curl_close($ch);

        $result = json_decode($response, true);
        if (!$result) {
            $this->logger->error('JSON parsing error/NULL API response');
            return null;
        }

        if (!empty($result['errors'])) {
            $this->logger->error( "Got some errors from API: " . json_encode($result['errors'], true) );
            return null;
        }

        return $result;
    }



    /**
     * method for parsing phone number.
     * !IMPORTANT: by this regular expression we will get all numbers without ANY symbols.
     * It`s not so good for offices numbers and extensions for them.
     * For example: for string "+123456-213" - we wil get answer "+123456213", the same answer will be for "+123456 #213"
     * @param $phone
     * @return false|string
     */
    private function transform_phone( $phone ){
        return substr( preg_replace("/[^+0-9]/", '', $phone), 0, 32 );
    }

}
