<?php
class ControllerExtensionShippingPastexpress extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/pastexpress');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->install();

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_pastexpress', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['pastexpress_secretkey'])) {
			$data['error_pastexpress_secretkey'] = $this->error['pastexpress_secretkey'];
		} else {
			$data['error_pastexpress_secretkey'] = '';
		}

		if (isset($this->error['pastexpress_pp_account'])) {
			$data['error_pastexpress_pp_account'] = $this->error['pastexpress_pp_account'];
		} else {
			$data['error_pastexpress_pp_account'] = '';
		}

		if (isset($this->error['pastexpress_pp_reg'])) {
			$data['error_pastexpress_pp_reg'] = $this->error['pastexpress_pp_reg'];
		} else {
			$data['error_pastexpress_pp_reg'] = '';
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
			'href' => $this->url->link('extension/shipping/pastexpress', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/pastexpress', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('shipping_pastexpress_' . $geo_zone['geo_zone_id'] . '_status');
			}
		}

		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['shipping_pastexpress_tax_class_id'])) {
			$data['shipping_pastexpress_tax_class_id'] = $this->request->post['shipping_pastexpress_tax_class_id'];
		} else {
			$data['shipping_pastexpress_tax_class_id'] = $this->config->get('shipping_pastexpress_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['shipping_pastexpress_status'])) {
			$data['shipping_pastexpress_status'] = $this->request->post['shipping_pastexpress_status'];
		} else {
			$data['shipping_pastexpress_status'] = $this->config->get('shipping_pastexpress_status');
		}

		if (isset($this->request->post['shipping_pastexpress_sort_order'])) {
			$data['shipping_pastexpress_sort_order'] = $this->request->post['shipping_pastexpress_sort_order'];
		} else {
			$data['shipping_pastexpress_sort_order'] = $this->config->get('shipping_pastexpress_sort_order');
		}

		if (isset($this->request->post['shipping_pastexpress_cod'])) {
			$data['shipping_pastexpress_cod'] = $this->request->post['shipping_pastexpress_cod'];
		} else {
			$data['shipping_pastexpress_cod'] = $this->config->get('shipping_pastexpress_cod');
		}

		if (isset($this->request->post['shipping_pastexpress_secretkey'])) {
			$data['shipping_pastexpress_secretkey'] = $this->request->post['shipping_pastexpress_secretkey'];
		} else {
			$data['shipping_pastexpress_secretkey'] = $this->config->get('shipping_pastexpress_secretkey');
		}

		if (isset($this->request->post['shipping_pastexpress_pp_account'])) {
			$data['shipping_pastexpress_pp_account'] = $this->request->post['shipping_pastexpress_pp_account'];
		} else {
			$data['shipping_pastexpress_pp_account'] = $this->config->get('shipping_pastexpress_pp_account');
		}

		if (isset($this->request->post['shipping_pastexpress_pp_reg'])) {
			$data['shipping_pastexpress_pp_reg'] = $this->request->post['shipping_pastexpress_pp_reg'];
		} else {
			$data['shipping_pastexpress_pp_reg'] = $this->config->get('shipping_pastexpress_pp_reg');
		}

		if (isset($this->request->post['shipping_pastexpress_hs_code'])) {
			$data['shipping_pastexpress_hs_code'] = $this->request->post['shipping_pastexpress_hs_code'];
		} else {
			$data['shipping_pastexpress_hs_code'] = $this->config->get('shipping_pastexpress_hs_code');
		}

		if (isset($this->request->post['shipping_pastexpress_origin_country'])) {
			$data['shipping_pastexpress_origin_country'] = $this->request->post['shipping_pastexpress_origin_country'];
		} else {
			$data['shipping_pastexpress_origin_country'] = $this->config->get('shipping_pastexpress_origin_country');
		}

		//Get Pasts country list
		$results = json_decode(@file_get_contents('https://ftp.webdev.lv/pasts/countries.json'), true);
		$data['countries'] = array();
		if(!empty($results)) {
			//Language code based on admin language
			switch($this->config->get('config_admin_language')) {
				case 'en-gb':
				case 'en':
				case 'en-en':
					$lang = 'en';
					break;
				case 'lv-lv':
				case 'lv':
					$lang = 'lv';
					break;
				case 'ru-ru':
				case 'ru':
					$lang = 'ru';
					break;
				default:
					$lang = 'en';
			}

			foreach($results as $result){
				if(isset($result['Country'])){
					$data['countries'][$result['Country']['id']] = $result['Country']['title_'.$lang] . ' ('.$result['Country']['iso2'] .')';
				} 			
			}
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['shipping_pastexpress_title'])) {
			$data['shipping_pastexpress_title'] = $this->request->post['shipping_pastexpress_title'];
		} else {
			$data['shipping_pastexpress_title'] = $this->config->get('shipping_pastexpress_title');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/pastexpress', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/pastexpress')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['shipping_pastexpress_secretkey']) < 1) || (utf8_strlen($this->request->post['shipping_pastexpress_secretkey']) > 64)) {
			$this->error['pastexpress_secretkey'] = $this->language->get('error_pastexpress_secretkey');
		}

		if ((utf8_strlen($this->request->post['shipping_pastexpress_pp_account']) < 1) || (utf8_strlen($this->request->post['shipping_pastexpress_pp_account']) > 64)) {
			$this->error['pastexpress_pp_account'] = $this->language->get('error_pastexpress_pp_account');
		}			
		
		if ((utf8_strlen($this->request->post['shipping_pastexpress_pp_reg']) < 1) || (utf8_strlen($this->request->post['shipping_pastexpress_pp_reg']) > 64)) {
			$this->error['pastexpress_pp_reg'] = $this->language->get('error_pastexpress_pp_reg');
		}

		return !$this->error;
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