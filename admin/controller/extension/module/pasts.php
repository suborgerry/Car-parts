<?php
class ControllerExtensionModulePasts extends Controller {
	private $error = array();
	private $eu_countries = ['BE', 'BG', 'CZ', 'DK', 'DE', 'EE', 'IE', 'GR', 'ES', 'FR', 'HR', 'IT', 'CY', 'LV', 'LT', 'LU', 'HU', 'MT', 'NL', 'AT', 'PL', 'PT', 'RO', 'SI', 'SK', 'FI', 'SE'];

	public function index() {
		$this->load->language('extension/module/pasts');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->install();

		if( isset($this->request->get['order_id']) ){
			$order_id = $this->request->get['order_id'];
		}else{
			$order_id = 0;
		}

		if( isset($this->request->get['label_type']) ){
			$label_type = $this->request->get['label_type'];
		}else{
			$label_type = '';
		}

		$this->load->model('setting/setting');
		$this->load->model('sale/order');
        $this->load->model('catalog/product');

		$order_info = $this->model_sale_order->getOrder($order_id);

		if( $order_info ){
			$order_past_info = $this->model_sale_order->getPastOrder($order_id);

			if($order_past_info){
				$order_info['shipping_dropdown_value'] = $order_past_info['shipping_dropdown_value'];
			}else{
				$order_info['shipping_dropdown_value'] = '';
			}

			/*
			$order_shipment_info = $this->model_sale_order->getShipmentNumber($order_id);
			if($order_shipment_info && $label_type != 'create_shipment'){
				$order_shipment_number = $order_shipment_info['shipment_number'];
				if($order_shipment_number){
					$shipNmber = array(
						$order_info['order_id'] => $order_shipment_number
					);						
					$binary_data = $this->printSticker($shipNmber);					
			 		$this->getLabelsOutput($binary_data, $order_info['order_id']);		
			 		exit;
				}
			}
			*/

			$response = $this->createShipment($order_info); 

			if (!is_array($response)) {
			 	// JSON data
				$shipment_data = json_decode($response, true); 
				
				//echo '<pre>'; print_r($shipment_data); exit;
			 	
			 	$createStatus = true;

			 	$shipping_code = '';
	 			if( $order_info['shipping_code'] ){
					$shipping_code_string = explode('.', $order_info['shipping_code']);
					if( isset($shipping_code_string[0]) ){
						$shipping_code = $shipping_code_string[0];
					}
				}

			 	if(!$shipment_data || !$shipping_code){
			 		$createStatus = false;
			 		$this->session->data['past_error'] = 'No Shipment Data Found!';
			 	}elseif( isset($shipment_data['error']) ){
			 		$createStatus = false;
			 		$this->session->data['past_error'] = $shipment_data['error'];		
			 	}elseif( !isset( $shipment_data[$order_info['order_id']] ) ){
			 		$createStatus = false;
			 		$this->session->data['past_error'] = 'Shipment Error!';			 	
			 	}elseif( isset($shipment_data[$order_info['order_id']]) && is_array($shipment_data[$order_info['order_id']]) ){
			 		$createStatus = false;
			 		$this->session->data['past_error'] = json_encode($shipment_data[$order_info['order_id']], JSON_UNESCAPED_UNICODE );
			 	}

			 	if( $createStatus && isset($shipment_data[$order_info['order_id']]) && is_string($shipment_data[$order_info['order_id']]) ){
			 		
					$country_code = $order_info['shipping_iso_code_2'];

					// order comments or history entry

					$this->model_sale_order->addOrderHistory($order_info['order_id'], $order_info['order_status_id'], $shipment_data[$order_info['order_id']]);

					if($label_type == 'create_shipment'){
						$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
					}

					if( $shipping_code == 'pastexpress' && ( mb_strtoupper($country_code) != 'LT' && mb_strtoupper($country_code) != 'LV') ){
						$binary_data = $this->printLabel($shipment_data, $shipping_code);
						
					}else{
						$binary_data = $this->printSticker($shipment_data, $shipping_code);
					}			 						 		
		 						 		
			 		$this->getLabelsOutput($binary_data, $order_id);
			 		
			 	}else{
			 		$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
			 	}

			} else { 
				//echo '<pre>'; print_r($response); exit;
			 	//die("ERROR ({$response['code']}): {$response['text']}");
			 	if($response['text']){
			 		$this->session->data['past_error'] = $response['text'];
			 	}else{
			 		$this->session->data['past_error'] = 'Shipment Error!';
			 	}
			 	
			 	$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
			}	
		}else{
			$this->response->redirect( $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true) );
		}

	}

	protected function createShipment($order_info){ 
		$countries = $this->getCountries(); 
		$url = 'https://express.pasts.lv/parcelsApi/create';

		$response = array();
		$shipment_data = array();

		$country_code = $order_info['shipping_iso_code_2'];
		// Make 1 variable that stores country ID for LV, LT or EE
		switch (mb_strtoupper($country_code)) {
			case "LV":
				$baltic_country_id = $countries['LV']['id'] ?? '7';
				break;
			case "LT":
				$baltic_country_id = $countries['LT']['id'] ?? '2';
				break;
			case "EE":
				$baltic_country_id = $countries['EE']['id'] ?? '1';
				break;
			default:
				$baltic_country_id = '';
		}

		$product_data = $this->getOrderProducts($order_info);

		if( $order_info['shipping_code'] ){
			$shipping_code_string = explode('.', $order_info['shipping_code']);
			if( isset($shipping_code_string[0]) ){
				$shipping_code = $shipping_code_string[0];
				if( $shipping_code == 'pastpickup' && $order_info['payment_code'] == 'cod' ){
					
					if (mb_strtoupper($country_code) == 'LT') {
						$country_type = 'Be';
						$pickup_zip = trim($order_info['shipping_dropdown_value'], ' ');
					}elseif(mb_strtoupper($country_code) == 'LV' ) {
						$country_type = 'Ie';
						$pickup_zip = 'LV-'.trim($order_info['shipping_dropdown_value'], ' ');
					}else{
						$country_type = '';
						$pickup_zip = '';
					}

					if($country_type){
						$shipment_data = array(
							$order_info['order_id'] =>	array(
								"type" => $country_type,
								"name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
								"phone" => $order_info['telephone'],
								"email" => $order_info['email'],
								"country_id" => $baltic_country_id,
								"city"=> $order_info['shipping_city'] ? $order_info['shipping_city'] : $order_info['shipping_zone'],
								"street" => $order_info['shipping_address_1'],	
								"zipcode" => $order_info['shipping_postcode'],
								"comments" => $order_info['comment'],
								"pickup" => 1,
								"pickup_zipcode" => $pickup_zip,
								"sms_invite" => 1,
								"insured" => 1,
								"insurance_sum" => number_format($order_info['total'], 2, '.', ''),
								"post_payment" => 1,
								"post_payment_sum" => number_format($order_info['total'], 2, '.', ''),
								"post_payment_account" => $this->config->get('shipping_pastpickup_pp_account'),
								"post_payment_aim" => "Order ".$order_info['order_id'],
								"post_payment_payer" => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
								"post_payment_reg_number" => $this->config->get('shipping_pastpickup_pp_reg'),
								"post_payment_details" => $order_info['payment_address_1']
							)
						);  
					}else{
						$shipment_data = array();
					}					
				}elseif( $shipping_code == 'pastpickup' && $order_info['payment_code'] != 'cod' ){
					if(mb_strtoupper($country_code) == 'LV' || mb_strtoupper($country_code) == 'LT') {					
						$shipment_data = array(
							$order_info['order_id'] =>	array(
								"name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
								"phone" => $order_info['telephone'],
								"email" => $order_info['email'],
								"country_id" => $baltic_country_id,
								"city"=> $order_info['shipping_city'] ? $order_info['shipping_city'] : $order_info['shipping_zone'],
								"street" => $order_info['shipping_address_1'],	
								"zipcode" => $order_info['shipping_postcode'],
								"comments" => $order_info['comment'],
								"pickup" => 1,
							)
						);

						// Different data for LV and LT
						switch (mb_strtoupper($country_code)) {
							case "LV":
								$shipment_data[$order_info['order_id']]['type'] = "Ie";
								$shipment_data[$order_info['order_id']]['pickup_zipcode'] = 'LV-'.trim($order_info['shipping_dropdown_value'], ' ');
								$shipment_data[$order_info['order_id']]['sms_invite'] = 1;
								break;
							case "LT":
								$shipment_data[$order_info['order_id']]['type'] = "Be";
								$shipment_data[$order_info['order_id']]['pickup_zipcode'] = trim($order_info['shipping_dropdown_value'], ' ');
								break;
							default:
						}
					}else{
						$shipment_data = array();
					}				
				}elseif( $shipping_code == 'pastterminal' ){
					if (mb_strtoupper($country_code) == 'LV' || mb_strtoupper($country_code) == 'LT') {
						$shipment_data = array(
							$order_info['order_id'] =>	array(
								 "name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
								 "phone" => $order_info['telephone'],
								 "email" => $order_info['email'],
								 "country_id" => $baltic_country_id,
								 "comments" => $order_info['comment'],
							)
						);

						// Different data for LV and LT
						switch (mb_strtoupper($country_code)) {
							case "LV":
								$shipment_data[$order_info['order_id']]['type'] = "Ie";
								$shipment_data[$order_info['order_id']]['station_id'] = trim($order_info['shipping_dropdown_value']);
								break;
							case "LT":
								$shipment_data[$order_info['order_id']]['type'] = "Be";
								$shipment_data[$order_info['order_id']]['size'] = "Medium";
								$shipment_data[$order_info['order_id']]['zipcode'] = $order_info['shipping_postcode'];
								$shipment_data[$order_info['order_id']]['city'] = $order_info['shipping_city'] ? $order_info['shipping_city'] : $order_info['shipping_zone'];
								$shipment_data[$order_info['order_id']]['terminal_id'] = trim($order_info['shipping_dropdown_value']);
								break;
							default:
						}
						
						if($order_info['payment_code'] == 'cod'){
							$shipment_data[$order_info['order_id']]["insured"] = 1;
							$shipment_data[$order_info['order_id']]["insurance_sum"] = number_format($order_info['total'], 2, '.', '');
							$shipment_data[$order_info['order_id']]["post_payment"] = 1;
							$shipment_data[$order_info['order_id']]["post_payment_sum"] = number_format($order_info['total'], 2, '.', '');
							$shipment_data[$order_info['order_id']]["post_payment_account"] = $this->config->get('shipping_pastterminal_pp_account'); 
							$shipment_data[$order_info['order_id']]["post_payment_aim"] = "Order ".$order_info['order_id'];
							$shipment_data[$order_info['order_id']]["post_payment_payer"] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
							$shipment_data[$order_info['order_id']]["post_payment_reg_number"] = $this->config->get('shipping_pastterminal_pp_reg');
							$shipment_data[$order_info['order_id']]["post_payment_details"] = $order_info['payment_address_1'];	
						}
					}else{
						$shipment_data = array();
					}
				}elseif( $shipping_code == 'pastcirclek' ){
					$shipment_data = array(
						$order_info['order_id'] =>	array(
							"type" => "Ie",
							 "name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
							 "phone" => $order_info['telephone'],
							 "email" => $order_info['email'],
							 "country_id" => $baltic_country_id,
							 "comments" => $order_info['comment'],
							 "statoil_id" => trim($order_info['shipping_dropdown_value'])
						)
					);

					if($order_info['payment_code'] == 'cod'){
						$shipment_data[$order_info['order_id']]["insured"] = 1;
						$shipment_data[$order_info['order_id']]["insurance_sum"] = number_format($order_info['total'], 2, '.', '');
						$shipment_data[$order_info['order_id']]["post_payment"] = 1;
						$shipment_data[$order_info['order_id']]["post_payment_sum"] = number_format($order_info['total'], 2, '.', '');
						$shipment_data[$order_info['order_id']]["post_payment_account"] = $this->config->get('shipping_pastcirclek_pp_account'); 
						$shipment_data[$order_info['order_id']]["post_payment_aim"] = "Order ".$order_info['order_id'];
						$shipment_data[$order_info['order_id']]["post_payment_payer"] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
						$shipment_data[$order_info['order_id']]["post_payment_reg_number"] = $this->config->get('shipping_pastcirclek_pp_reg');
						$shipment_data[$order_info['order_id']]["post_payment_details"] = $order_info['payment_address_1'];	
					}
				}elseif( $shipping_code == 'pastexpress' ){					
					if (mb_strtoupper($country_code) == 'LT' || mb_strtoupper($country_code) == 'EE') {
						$country_type = 'Be';
					}elseif(mb_strtoupper($country_code) == 'LV' ) {
						$country_type = 'Ie';
					}else{
						$country_type = 'Ems';
						$country_number = $countries[mb_strtoupper($country_code)]['id'] ?? '';						
					}

					if($country_type == 'Be' || $country_type == 'Ie'){
						$shipment_data = array(
							$order_info['order_id'] =>	array(
								"type" => $country_type,
								"name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
								"phone" => $order_info['telephone'],
								"email" => $order_info['email'],
								"country_id" => $baltic_country_id,
								"city"=> $order_info['shipping_city'] ? $order_info['shipping_city'] : $order_info['shipping_zone'],
								"street" => $order_info['shipping_address_1'],	
								"zipcode" => $order_info['shipping_postcode'],
								"comments" => $order_info['comment'],
								"ParcelContent" => $product_data
							)
						);

						if($order_info['payment_code'] == 'cod'){
							$shipment_data[$order_info['order_id']]["insured"] = 1;
							$shipment_data[$order_info['order_id']]["insurance_sum"] = number_format($order_info['total'], 2, '.', '');
							$shipment_data[$order_info['order_id']]["post_payment"] = 1;
							$shipment_data[$order_info['order_id']]["post_payment_sum"] = number_format($order_info['total'], 2, '.', '');
							$shipment_data[$order_info['order_id']]["post_payment_account"] = $this->config->get('shipping_pastexpress_pp_account'); 
							$shipment_data[$order_info['order_id']]["post_payment_aim"] = "Order ".$order_info['order_id'];
							$shipment_data[$order_info['order_id']]["post_payment_payer"] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
							$shipment_data[$order_info['order_id']]["post_payment_reg_number"] = $this->config->get('shipping_pastexpress_pp_reg');
							$shipment_data[$order_info['order_id']]["post_payment_details"] = $order_info['payment_address_1'];	
						}
						
						if(mb_strtoupper($country_code) == 'EE' ) {
							$shipment_data[$order_info['order_id']]["content_currency"] = $order_info['currency_code'];
						}
					}elseif($country_type == 'Ems' && $country_number){
						$shipment_data = array(
							$order_info['order_id'] =>	array(
								"type" => $country_type,
								"name_surname" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
								"phone" => $order_info['telephone'],
								"email" => $order_info['email'],
								"country_id" => $country_number,
								"city"=> $order_info['shipping_city'] ? $order_info['shipping_city'] : $order_info['shipping_zone'],
								"street" => $order_info['shipping_address_1'],	
								"zipcode" => $order_info['shipping_postcode'],
								"comments" => $order_info['comment'],
 								"package_contents" => "Prece",
 								"content_currency" => $order_info['currency_code'],
								"ParcelContent" => $product_data
							)
						);

						if($country_code == 'US') {
							$shipment_data[$order_info['order_id']]['zip_state'] = $order_info['shipping_zone_code'] ?? '';
						}
						if($country_code == 'US' || $country_code == 'RU') {
							$shipment_data[$order_info['order_id']]['house'] = '.';
						}
					}else{
						$shipment_data = array();
					}

				}else{
					$shipment_data = array();
				} 

				$post_data = array(
		 			"secret" => $this->config->get('shipping_'.$shipping_code.'_secretkey'),
		 			"parcels" => $shipment_data
		 		);  

				$response = $this->send($url, json_encode($post_data), false); 
/*
echo "<pre>";
print_r($response);
echo "<br />";
print_r($shipment_data);
echo "<br />";
echo "</pre>";
die();
*/
			}
		} 

		return $response;

	}

	protected function printLabel($shipment_data, $shipping_code){
		$url = 'https://express.pasts.lv/parcelsDocumentsApi/labels';

 		$post_data = array(
 			"secret" => $this->config->get('shipping_'.$shipping_code.'_secretkey'),
 			"parcels" => $shipment_data
 		);			 		
 			 		
 		$binary_data = $this->send($url, json_encode($post_data), false);

 		return $binary_data;
	}

	protected function printSticker($shipment_data, $shipping_code){
		$url = 'https://express.pasts.lv/parcelsDocumentsApi/stickers';

 		$post_data = array(
 			"secret" => $this->config->get('shipping_'.$shipping_code.'_secretkey'),
 			"size" => "150x100",
 			"parcels" => $shipment_data
 		);			 		
 			 		
 		$binary_data = $this->send($url, json_encode($post_data), false);

 		return $binary_data;
	}

	public function expressManifest() {
		$orders = $parcels = array();
		$secretkey = '';

		if (!empty($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		}else{
			$this->session->data['error_pasts'] = 'Please select an order';
			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}
		
		$this->load->model('sale/order');
		$express_methods = ['pastexpress', 'pastpickup', 'pastterminal', 'pastcirclek']; 
		
		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$shipping_code = explode('.', $order_info['shipping_code']);
				if (in_array($shipping_code[0], $express_methods)) {
					if(!$secretkey) {
						$secretkey = $this->config->get('shipping_'.$shipping_code[0].'_secretkey');
					}
					
					$shipment_no = $this->model_sale_order->getShipmentNumber($order_info['order_id']);
					if(!empty($shipment_no['shipment_number'])) {
						$parcels[] = $shipment_no['shipment_number'];
					}else{
						$this->session->data['error_pasts'] = 'Order #'.$order_info['order_id'].' doesn\'t have an Expresspasts parcel number. Try generating label first.';
						$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));					
					}
				}else{
					$this->session->data['error_pasts'] = 'Order #'.$order_info['order_id'].' doesn\'t have a ExpressPasts shipping method';
					$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));				
				}
			}
		}

		$url = 'https://express.pasts.lv/parcelsDocumentsApi/manifest';
 		$post_data = array(
 			"secret" => $secretkey,
 			"parcels" => $parcels
 		);			 		
 		
 		$binary_data = $this->send($url, json_encode($post_data), false);
		
		$error_check = json_decode($binary_data, true);
		if(!empty($error_check['error']) || !empty($error_check['code'])) {
			$this->session->data['error_pasts'] = $error_check['error'] ?? ($error_check['code'] . ' ' . $error_check['text']);
			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}else{
			$this->getLabelsOutput($binary_data, '', 'expressManifest');
			//$this->session->data['success_pasts'] = 'Express pasts manifests izveidots';
		}
	}

	public function manspastsManifest() {
		$orders = $parcels = $manifest_url = $shipment_ids = array();
		
		if (!empty($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		}else{
			$this->session->data['error_pasts'] = 'Please select an order';
			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}
		
		$this->load->model('sale/order');
		
		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$shipping_code = explode('.', $order_info['shipping_code']);
				if ($shipping_code[0] == 'pastmypost') {			
					$shipment_no = $this->model_sale_order->getShipmentNumber($order_info['order_id']);
					if(!empty($shipment_no['shipment_number'])) {
						$parcels[] = $shipment_no['shipment_number'];
						$manifest_url[] = $shipment_no['manifest_url'];
						$shipment_ids[] = $shipment_no['pasts_id'];
					}else{
						$this->session->data['error_pasts'] = 'Order #'.$order_info['order_id'].' doesn\'t have a MansPasts parcel number. Try generating label first.';
						$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));					
					}
				}else{
					$this->session->data['error_pasts'] = 'Order #'.$order_info['order_id'].' doesn\'t have a MansPasts shipping method';
					$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));				
				}
			}
		}

		// Check if all manifest URLs are the same. No need to generate manifest in that case
		$equal_manifests = (count(array_unique($manifest_url)) === 1);
		if($equal_manifests && !empty($manifest_url[0])) {
			$response['link'] = $manifest_url[0];
		}else{
			$url = $this->config->get('shipping_pastmypost_mode') ? 'apidemo.manspasts.lv/api/combine-ps27' : 'www.manspasts.lv/api/combine-ps27';
			$post_data['combine_ps27'] = array(
				"user" => $this->config->get('shipping_pastmypost_username'),
				"api_key" => $this->config->get('shipping_pastmypost_apikey'),
				"packageIds" => $parcels
			);			 		
			
			$response = $this->getData($url, 'POST', $post_data);
		}

		if(!empty($response['link'])){
			$this->model_sale_order->insertManifestUrl($shipment_ids, $response['link']); // Update DB with manifest URL
		
			$pdfname = time().'_manspasts_manifest.pdf';
			$file_url = $response['link'];
			header('Content-Type: application/pdf');
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=".$pdfname);
			readfile($file_url);
		}else{
			if(!empty($response['message'])) {
				if(is_array($response['message']) || is_object($response['message'])) {
					$this->session->data['error_pasts'] = json_encode($response['message'], JSON_UNESCAPED_UNICODE);
				}else{
					$this->session->data['error_pasts'] = $response['message'];
				}
			}else{
				$this->session->data['error_pasts'] = json_encode($response, JSON_UNESCAPED_UNICODE);
			}
			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}
	}
	
	public function manspasts() {
		$this->load->language('extension/module/pasts');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->install();

		if( isset($this->request->get['order_id']) ){
			$order_id = $this->request->get['order_id'];
		}else{
			$order_id = 0;
		}

		if( isset($this->request->get['label_type']) ){
			$label_type = $this->request->get['label_type'];
		}else{
			$label_type = '';
		}

		$this->load->model('setting/setting');
		$this->load->model('sale/order');
		$this->load->model('catalog/product');

		$order_info = $this->model_sale_order->getOrder($order_id);

		if( $order_info ){
			$country_code = $order_info['shipping_iso_code_2'];

			$shipping_code_string = isset($order_info['shipping_code']) ? explode('.', $order_info['shipping_code']) : [];
			$shipping_code = $shipping_code_string[1] ?? ''; // Get gthe part with geozone
			$ptype = explode('_', $this->config->get('shipping_'.$shipping_code.'_postage_type'));
			$item_type = $ptype[0] ?? '';
			$postage_type = $ptype[1] ?? '';

			$url = $this->config->get('shipping_pastmypost_mode') ? 'https://apidemo.manspasts.lv/api/packages' : 'https://www.manspasts.lv/api/packages';			
			$post_data = array(
				"package_create" => array(
					"user" => $this->config->get('shipping_pastmypost_username'), 
					"api_key" => $this->config->get('shipping_pastmypost_apikey'), 
					"type" => 'Goods', 
					"postageType" => $postage_type, 
					"itemType" => $item_type,
					"addresses" => array( 
						array(
							"countryCode" => mb_strtoupper($country_code), 
							"postCode" => $order_info['shipping_postcode'], 
							"freeformAddressLine1" => $order_info['shipping_address_1'],
							"freeformAddressLine2" => $order_info['shipping_city'],
							"name" => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
							"phone" => $order_info['telephone'],
							"email" => $order_info['email'],
						)
					)
				)
			);

			if(in_array($country_code, $this->eu_countries) && $country_code != 'LV') {
				$post_data['package_create']['addresses'][0]['userPackageWeight'] = $this->getOrderWeight($order_info);
			}

			// Add state to US shipment
			if($country_code == 'US') {
				$post_data['package_create']['addresses'][0]['freeformAddressLine2'] .= ', ' . $order_info['shipping_zone_code'];
			}

			// Add product data to non-EU country orders
			if(!in_array($country_code, $this->eu_countries)) {
				$prod_data = $this->getOrderProducts($order_info);
				$content_items = array();
				foreach($prod_data as $prod) {
					$content_items[] = array(
						'name' => $prod['title'],
						'quantity' => (int)$prod['amount'],
						'weight' => (int)($prod['weight'] * 1000),
						'value' => $prod['value'],
						'hsCode' => $this->config->get('shipping_pastmypost_hs_code'),
						'country' => $this->config->get('shipping_pastmypost_origin_country'),
					);
				}

				$post_data['package_create']['addresses'][0]['contentItems'] = $content_items;
				$post_data['package_create']['addresses'][0]['contentType'] = 'Other';
			}

			$response = $this->getData($url, 'POST', $post_data);
/*
echo "<pre>";
print_r($response);
echo "<br />";
print_r($post_data);
echo "<br />";
echo "</pre>";
die();
*/
			$status = false;
			if(is_array($response)){
				if(isset($response['code']) && $response['code'] == '201'){
					$status = true;
				}else{
					if( isset($response['message']) ){
						$this->session->data['past_error'] = $response['message'];
					}
				}
			}

			if($status && isset($response['packageId'])){
				// order comments or history entry
				$this->model_sale_order->addOrderHistory($order_info['order_id'], $order_info['order_status_id'], $response['packageId']);

				if($label_type == 'create_shipment'){
					$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
				}

				$this->printDocument($order_id, $response['packageId'], mb_strtoupper($country_code));

			}else{
				$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
			}
		}else{
			$this->response->redirect( $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true) );
		}

	}

	protected function printDocument($order_id, $packageId, $country_code){

		$url = $this->config->get('shipping_pastmypost_mode') ? 'https://apidemo.manspasts.lv/api/documents' : 'https://www.manspasts.lv/api/documents';

		$post_data = array(
			"document" => array(
				"user" => $this->config->get('shipping_pastmypost_username'), 
				"api_key" => $this->config->get('shipping_pastmypost_apikey'), 
				"package" => $packageId,
				//"barcode" => $response['barcodes'][0],				
				"documentType" => $country_code == "LV" ? "Address labels" : "Accompanying documents", 
				"addressLabelType" => "Addressee", 
				"addressLabelLayout" => "3x8", 
				"addressLabelDimensions" => "70x35", 
				"addressLabelInitialColumn" => 1, 
				"addressLabelInitialRow" => 1
			)
		);

		// Print label in A4 if outside EU and Item type == Parcel
		if(!in_array($country_code, $this->eu_countries)) {
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($order_id);
			if( $order_info ){
				$shipping_code_string = isset($order_info['shipping_code']) ? explode('.', $order_info['shipping_code']) : [];
				$shipping_code = $shipping_code_string[1] ?? ''; // Get gthe part with geozone
				$ptype = explode('_', $this->config->get('shipping_'.$shipping_code.'_postage_type'));
				$item_type = $ptype[0] ?? '';

				if(mb_strtolower($item_type) == 'parcel') {
					$post_data['document']['documentPrintType'] = 'A4';
				}
			}		
		}

		$response = $this->getData($url, 'POST', $post_data);
		//echo '<pre>'; print_r($response); exit;
		if(isset($response['link'])){
			$pdfname ='manspasts_label'.time().'.pdf';
			$file_url = $response['link'];
			header('Content-Type: application/pdf');
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=".$pdfname);
			readfile($file_url);
		}else{
			$this->response->redirect( $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true) );
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/pasts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	// Force PDF document download
	private function getLabelsOutput($pdf, $order_id = '', $file_name = 'pastsLabels') { 
		ob_get_clean();

		$today = time();
		$name = $file_name . '-'.$today. '.pdf';

		if($order_id) {
			$redirect_url = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true);
		}else{
			$redirect_url = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);
		}

		if (ob_get_contents()) { 
			$this->session->data['error_pasts'] = 'Some data has already been output, can\'t send PDF file';
			$this->response->redirect($redirect_url);
		}

		header('Content-Description: File Transfer');
		if (headers_sent()) {
			$this->session->data['error_pasts'] = 'Some data has already been output to browser, can\'t send PDF file';
			$this->response->redirect($redirect_url);
		}

		header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header( "refresh:1;url=".(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:''."" ); 
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream', false);
		header('Content-Type: application/download', false);
		header('Content-Type: application/pdf', false);
		header('Content-Disposition: attachment; filename="'.$name.'";');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.strlen($pdf));

		echo $pdf;

		return '';
	}

	private function send($url, $data = null, $checkCert = true) { 
		$curl = curl_init();
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $checkCert);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $checkCert);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_POSTREDIR, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		if (is_string($data)) {
			$data = json_decode($data, true);
		}

		if (empty($data) || !is_array($data)) {
			return false;
		}
		 // Content-Type: application/x-www-form-urlencoded
		$data = http_build_query($data);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
		$response = curl_exec($curl);  
		$errCode = curl_errno($curl);
		$errText = curl_error($curl);
		curl_close($curl);
		if (!empty($errCode)) {
			$response = array(
		 		'code' => $errCode,
		 		'text' => $errText
		 	);
		}

		return $response;
	}

	protected function getProductVolume($product_id){		
		$this->load->model('catalog/product');

		$volume = 0;

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if($product_info){
			$volume = $product_info['length'] * $product_info['width'] * $product_info['height'];	
		}

		return $volume;
	}

	protected function getProductWeight($product_id){		
		$this->load->model('catalog/product');
		$weight = 0.01;
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if(!empty($product_info) && $product_info['weight'] != 0){				
			$weight = $this->weight->convert($product_info['weight'], $product_info['weight_class_id'], $this->config->get('config_weight_class_id'));
		}

		return (float)$weight;
	}

	public function getCountries(){
						 	 			 	
 		$results = $this->getData('https://ftp.webdev.lv/pasts/countries.json');

 		$countries = array();

 		foreach($results as $result){
 			if(isset($result['Country'])){
 				$countries[$result['Country']['iso2']] = $result['Country'];
 			} 			
 		}
 		
 		return $countries;
	}

	protected function getOrderProducts($order_info){
		if(!in_array($order_info['shipping_iso_code_2'], $this->eu_countries)) {
			$hs_code = $this->config->get('shipping_pastexpress_hs_code');
			$origin_country_id = $this->config->get('shipping_pastexpress_origin_country');
			$outside_eu = true;
		}else{
			$outside_eu = false;
		}

		$product_data = array();
		$this->load->model('sale/order');
		$products = $this->model_sale_order->getOrderProducts($order_info['order_id']);

		foreach ($products as $product) {						
			$weight = $this->getProductWeight($product['product_id']);			

			$data = array(
				'title'    => $product['name'],
				'model'    => $product['model'],			
				'amount'   => $product['quantity'],
				'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'value'    => $product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0),
				'weight' => $weight
			);
			if($outside_eu) {
				$data['hs_code'] = $hs_code;
				$data['origin_country_id'] = $origin_country_id;
			}

			$product_data[] = $data;
		}

		return $product_data; 
	}

	protected function getOrderWeight($order_info){

		$weight = 0.01;

		$this->load->model('sale/order');

		$products = $this->model_sale_order->getOrderProducts($order_info['order_id']);

		foreach ($products as $product) {						

			$weight2 = $this->getProductWeight($product['product_id']);
			
			$weight += $weight2;
		}

		return (float)$weight; 
	}

	public function getData($api_url = '', $method = 'GET', $post = '') {

		$end_url = $api_url;

		header('Content-Type: application/json'); 

		if($method == 'POST'){
			$ch = curl_init($end_url); 
		}else{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $end_url); 
		}		

		//$authorization = "Authorization: Bearer ".$this->access_user_token; // Prepare the authorisation user_token

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  

		if($method == 'POST' && $post){ 
			$post = json_encode($post); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}    
		if($method == 'DELETE' && $post){ 
			$post = json_encode($post); 
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		} 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		$result = curl_exec($ch);   
		curl_close($ch); 

		return json_decode($result, true); 
    }

	public function install(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pasts_orders` (
            `pasts_id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` int(11) NOT NULL,
            `shipping_dropdown_value` VARCHAR(50) NOT NULL,
            `shipping_dropdown_text` VARCHAR(50) NOT NULL,
            PRIMARY KEY (`pasts_id`)
        )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pasts_shipments` (
            `pasts_id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` int(11) NOT NULL,
            `shipment_number` VARCHAR(50) NOT NULL,
				`manifest_url` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`pasts_id`)
        )");
	}

}