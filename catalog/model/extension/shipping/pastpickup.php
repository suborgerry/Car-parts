<?php
class ModelExtensionShippingPastpickup extends Model {
	public function getQuote($address) {
		$this->load->language('extension/shipping/pastpickup');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		$shipping_country_code = $this->session->data['shipping_address']['iso_code_2'];
		$shipping_city = $this->session->data['shipping_address']['city'];


		foreach ($query->rows as $result) {
			if ($this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}


				$shipping_country_code = strtolower($shipping_country_code);				

				if ($shipping_country_code == 'lt') {
		            $parcels = $this->getParcelSelect(strtolower($shipping_country_code), $shipping_city, $result['geo_zone_id']);
		        } else if ($shipping_country_code == 'lv') {
		            $parcels = $this->getParcelSelect(strtolower($shipping_country_code), $shipping_city, $result['geo_zone_id']);
		        } else if ($shipping_country_code == 'ee') {
		            $parcels = $this->getParcelSelect(strtolower($shipping_country_code), $shipping_city, $result['geo_zone_id']);
		            $status = false;
		        } else {
		            $parcels = $this->getParcelSelect(strtolower($shipping_country_code), $shipping_city, $result['geo_zone_id']);
		            $status = false;
		        }

		        if(!$parcels){
	        		$status = false;
	        	}

//$status = true;

		        $weight = $this->cart->getWeight();	

		        if ($this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxweight') != '') {
					if ( $weight > (float)$this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxweight' ) ) {
						$status = false;
					}	
				}	

				$volume = $this->cart->getVolume();	

				if ( $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxlength') != '' && $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxwidth') != '' && $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxheight') != '') {

					$v = (float) $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxlength') * (float) $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxwidth') * (float) $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_maxheight');
					if($volume > $v){
						$status = false;
					}

				}			
			

				if ( $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_category') ) {
					
					$category_data = $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_category'); 

					foreach ($this->cart->getProducts() as $product) {						

						foreach ($category_data as $category_id) {
							$category_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_category` WHERE `product_id` = '" . (int)$product['product_id'] . "' AND category_id = '" . (int)$category_id . "'");

							if ($category_query->row['total']) {
								$status = false;
							}
						}
					}				
				}

				
		        $js = "
		            <script type='text/javascript'>
		                $(document).ready(function() {
		                    var selector = 'input[value=\"pastpickup.pastpickup_" . $result['geo_zone_id'] . "\"]';
		                    var el = $(selector);
		                    var orig_value = el.val();
		                    var dropdown = el.parent().parent().find('.select-pastpickup-class').first();
		                    // el.val(orig_value + '|' + $(dropdown).val() + '|' + $(dropdown).find('option:selected').text().replace('|', ','));
		                    $(dropdown).change(function(e) {
		                        var value = $(this).val();
		                        var text = $(this).find('option:selected').text();
		                        el.prop('checked', true);
		                        //el.val(orig_value + '|' + value + '|' + text.replace('|', ','));
		                        el.prop('checked', 'checked');
		                    })
		                })
		            </script>
		        ";


			if ($status) { 
				$cost = $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_rate');	
				
				// free shipping
				if ($this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_freeshipping') != '') {
					if ($this->cart->getSubTotal() > str_replace(',', '.', $this->config->get('shipping_pastpickup_' . $result['geo_zone_id'] . '_freeshipping'))) {
						$cost = 0;
					}
				}	
				

				if ($cost == 0) {
					$title = $this->language->get('text_free_shipping') . ' | ';
					$text = $this->currency->format(0, $this->session->data['currency']);
				} else {
					$title = $this->language->get('text_additional_shipping_title') . ' | ';
					$text = $this->currency->format($this->tax->calculate($cost, $this->config->get('shipping_pastpickup_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']);
				}


				$extension_title = $parcels . $js;

				if ((string)$cost != '') {
					$quote_data['pastpickup_' . $result['geo_zone_id']] = array(
						'code'         => 'pastpickup.pastpickup_' . $result['geo_zone_id'],
						//'title'        => $result['name'] . '  (' . $this->language->get('text_pastpickup') . ' ' . $this->weight->format($weight, $this->config->get('config_pastpickup_class_id')) . ')',
						'title'        => $extension_title,
						'title_alternate' => $this->language->get('text_title'), 
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('shipping_pastpickup_tax_class_id'),
						//'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('pastpickup_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
						'text'         => $text
					);
				}


			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'pastpickup',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_pastpickup_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}

	public function getParcelSelect($country, $city, $geoZone) {

		$this->load->language('extension/shipping/pastpickup');

		if (isset($this->config->get('shipping_pastpickup_title')[$this->config->get('config_language_id')]['title']) && $this->config->get('shipping_pastpickup_title')[$this->config->get('config_language_id')]['title'] != '') {
		
			$pCustomTitle = $this->config->get('shipping_pastpickup_title')[$this->config->get('config_language_id')]['title'];
		}else{
			$pCustomTitle = $this->language->get('text_additional_shipping_title');
		}
    	
    	if ($country == 'lt') {
			$parcel_pickups = $this->getData('https://express.pasts.lv/postOfficeApi/lt');
		}else{
			$parcel_pickups = $this->getData('https://express.pasts.lv/postOfficeApi');
		}

        // Format dropdown

        if($parcel_pickups){

	        $nameId = "pastpickup_" . $geoZone;

	        $parcel_select = '<select name="'.$nameId.'" class="select-pastpickup-class full-width form-control">';

	        $parcel_select .= '<option value="0">'. $this->language->get('text_select') .'</option>';
	        
	        foreach ($parcel_pickups as $pickup) {
	        	 
	        	if ($country == 'lt') {
	        		$parcel_select .= '<option value=" '. $pickup['code'].'|'.$pCustomTitle.' '.$pickup['label'] .' ">';
	        		$parcel_select .= $pickup['label'];
	        	}else{
	        		$parcel_select .= '<option value=" '. $pickup['postcode'].'|'.$pCustomTitle.' '.$pickup['label'] .' ">';
	        		$parcel_select .= $pickup['label'];
	        	}                                
	            
	            $parcel_select .= '</option>';
	                                     
	        }
	        $parcel_select .= '</select>';
	    
	        return $parcel_select;
	    }else{
	    	return;
	    }  
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

		//$authorization = "Authorization: Bearer ".$this->access_token; // Prepare the authorisation token

		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));  

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
}