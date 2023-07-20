<?php
class ControllerExtensionShippingPastcirclek extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/pastcirclek');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->install();

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_pastcirclek', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['pastcirclek_secretkey'])) {
			$data['error_pastcirclek_secretkey'] = $this->error['pastcirclek_secretkey'];
		} else {
			$data['error_pastcirclek_secretkey'] = '';
		}

		if (isset($this->error['pastcirclek_pp_account'])) {
			$data['error_pastcirclek_pp_account'] = $this->error['pastcirclek_pp_account'];
		} else {
			$data['error_pastcirclek_pp_account'] = '';
		}

		if (isset($this->error['pastcirclek_pp_reg'])) {
			$data['error_pastcirclek_pp_reg'] = $this->error['pastcirclek_pp_reg'];
		} else {
			$data['error_pastcirclek_pp_reg'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/pastcirclek', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/pastcirclek', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_status');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_freeshipping'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_freeshipping'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_freeshipping'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_freeshipping'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_freeshipping');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxweight'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxweight'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxweight'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxweight'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxweight');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxlength'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxlength'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxlength'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxlength'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxlength');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxwidth'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxwidth'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxwidth'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxwidth'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxwidth');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxheight'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxheight'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxheight'];
			} else {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxheight'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_maxheight');
			}

			if (isset($this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'])) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'] = $this->request->post['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'];
			} elseif($this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category')) {
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'] = $this->config->get('shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category');
			}else{
				$data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'] = array();
			}

			// Categories
			$this->load->model('catalog/category');

			$data['product_categories_'.$geo_zone['geo_zone_id']] = array();

			foreach ($data['shipping_pastcirclek_' . $geo_zone['geo_zone_id'] . '_category'] as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);

				if ($category_info) {
					$data['product_categories_'.$geo_zone['geo_zone_id']][] = array(
						'category_id' => $category_info['category_id'],
						'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}
		}

		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['shipping_pastcirclek_tax_class_id'])) {
			$data['shipping_pastcirclek_tax_class_id'] = $this->request->post['shipping_pastcirclek_tax_class_id'];
		} else {
			$data['shipping_pastcirclek_tax_class_id'] = $this->config->get('shipping_pastcirclek_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['shipping_pastcirclek_status'])) {
			$data['shipping_pastcirclek_status'] = $this->request->post['shipping_pastcirclek_status'];
		} else {
			$data['shipping_pastcirclek_status'] = $this->config->get('shipping_pastcirclek_status');
		}

		if (isset($this->request->post['shipping_pastcirclek_sort_order'])) {
			$data['shipping_pastcirclek_sort_order'] = $this->request->post['shipping_pastcirclek_sort_order'];
		} else {
			$data['shipping_pastcirclek_sort_order'] = $this->config->get('shipping_pastcirclek_sort_order');
		}

		if (isset($this->request->post['shipping_pastcirclek_cod'])) {
			$data['shipping_pastcirclek_cod'] = $this->request->post['shipping_pastcirclek_cod'];
		} else {
			$data['shipping_pastcirclek_cod'] = $this->config->get('shipping_pastcirclek_cod');
		}

		if (isset($this->request->post['shipping_pastcirclek_secretkey'])) {
			$data['shipping_pastcirclek_secretkey'] = $this->request->post['shipping_pastcirclek_secretkey'];
		} else {
			$data['shipping_pastcirclek_secretkey'] = $this->config->get('shipping_pastcirclek_secretkey');
		}

		if (isset($this->request->post['shipping_pastcirclek_pp_account'])) {
			$data['shipping_pastcirclek_pp_account'] = $this->request->post['shipping_pastcirclek_pp_account'];
		} else {
			$data['shipping_pastcirclek_pp_account'] = $this->config->get('shipping_pastcirclek_pp_account');
		}

		if (isset($this->request->post['shipping_pastcirclek_pp_reg'])) {
			$data['shipping_pastcirclek_pp_reg'] = $this->request->post['shipping_pastcirclek_pp_reg'];
		} else {
			$data['shipping_pastcirclek_pp_reg'] = $this->config->get('shipping_pastcirclek_pp_reg');
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['shipping_pastcirclek_title'])) {
			$data['shipping_pastcirclek_title'] = $this->request->post['shipping_pastcirclek_title'];
		} else {
			$data['shipping_pastcirclek_title'] = $this->config->get('shipping_pastcirclek_title');
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/pastcirclek', $data));
	}

	protected function validate() { 
		if (!$this->user->hasPermission('modify', 'extension/shipping/pastcirclek')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['shipping_pastcirclek_secretkey']) < 1) || (utf8_strlen($this->request->post['shipping_pastcirclek_secretkey']) > 64)) {
			$this->error['pastcirclek_secretkey'] = $this->language->get('error_pastcirclek_secretkey');
		}

		if ((utf8_strlen($this->request->post['shipping_pastcirclek_pp_account']) < 1) || (utf8_strlen($this->request->post['shipping_pastcirclek_pp_account']) > 64)) {
			$this->error['pastcirclek_pp_account'] = $this->language->get('error_pastcirclek_pp_account');
		}			
		
		if ((utf8_strlen($this->request->post['shipping_pastcirclek_pp_reg']) < 1) || (utf8_strlen($this->request->post['shipping_pastcirclek_pp_reg']) > 64)) {
			$this->error['pastcirclek_pp_reg'] = $this->language->get('error_pastcirclek_pp_reg');
		}

		return !$this->error;
	}

	public function getParcelSelect() {

		if( isset($this->request->get['order_id']) ){
			$order_id = $this->request->get['order_id'];
		}else{
			$order_id = 0;
		}

		$this->load->model('sale/order');  

		$order_info = $this->model_sale_order->getOrder($order_id);

		$shipping_code = '';
		if($order_info){
			if( $order_info['shipping_code'] ){
				$shipping_code_string = explode('.', $order_info['shipping_code']);
				if( isset($shipping_code_string[0]) ){
					$shipping_code = $shipping_code_string[0];
				}
			}	
		}

		$order_past_info = $this->model_sale_order->getPastOrder($order_id);

		if( isset($this->request->get['country_id']) ){
			$shipping_country_id = $this->request->get['country_id'];
		}else{
			$shipping_country_id = '0';
		}

		if( isset($this->request->get['geoZone']) ){
			$geoZone = $this->request->get['geoZone'];

			$geoZoneval = explode('.', $geoZone);
			if(isset($geoZoneval[1])){
				$geoZone = $geoZoneval[1];	
			}
			
		}else{
			$geoZone = '';
		}

		$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$shipping_country_id . "'");

		if ($country_query->num_rows) {
			$shipping_iso_code_2 = $country_query->row['iso_code_2'];
			$shipping_iso_code_3 = $country_query->row['iso_code_3'];
		} else {
			$shipping_iso_code_2 = '';
			$shipping_iso_code_3 = '';
		}

		$country = strtolower($shipping_iso_code_2);

		$parcel_circleks = $this->getData('https://express.pasts.lv/dusApi/index');

        // Format dropdown

        $nameId = $geoZone;

        $parcel_select = '<select name="'.$nameId.'" class="select-pastcirclek-class full-width form-control" id="pasts-parcel-list">';

        $parcel_select .= '<option value="0">'. $this->language->get('text_select') .'</option>';
        if($parcel_circleks){
        	foreach ($parcel_circleks as $circlek) {

        	if($order_past_info){
				if($shipping_code == 'pastcirclek' && $order_past_info['shipping_dropdown_value'] == $circlek['id']){
					$selected = 'selected';
				}else{
					$selected = '';
				}
			}else{
				$selected = '';
			}

			if($selected){
				$parcel_select .= '<option selected="selected" value=" '. $circlek['id'].'|'.$circlek['title'] .' ">';
			}else{
				$parcel_select .= '<option value=" '. $circlek['id'].'|'.$circlek['title'] .' ">';
			}
        	                                
            $parcel_select .= $circlek['title'];
            $parcel_select .= '</option>';
                                     
        }	
        }
        
        $parcel_select .= '</select>';

        $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(['select' => $parcel_select]));
            
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
            PRIMARY KEY (`pasts_id`)
        )");
	}
}