<?php
class ControllerExtensionShippingPastmypost extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/pastmypost');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->install();

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_pastmypost', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['pastmypost_username'])) {
			$data['error_pastmypost_username'] = $this->error['pastmypost_username'];
		} else {
			$data['error_pastmypost_username'] = '';
		}

		if (isset($this->error['pastmypost_apikey'])) {
			$data['error_pastmypost_apikey'] = $this->error['pastmypost_apikey'];
		} else {
			$data['error_pastmypost_apikey'] = '';
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
			'href' => $this->url->link('extension/shipping/pastmypost', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/pastmypost', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_status');
			}

			if (isset($this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_postage_type'])) {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_postage_type'] = $this->request->post['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_postage_type'];
			} else {
				$data['shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_postage_type'] = $this->config->get('shipping_pastmypost_' . $geo_zone['geo_zone_id'] . '_postage_type');
			}
		}

		$data['geo_zones'] = $geo_zones;

		$data['postage_types'] = array(
			'Parcel_Registered' => 'Parcel - Registered',
			'Letter_Registered' => 'Letter - Registered',
			'Letter_Ordinary' => 'Letter - Ordinary',
			'Letter_Tracked' => 'Letter - Tracked',
		);

		if (isset($this->request->post['shipping_pastmypost_tax_class_id'])) {
			$data['shipping_pastmypost_tax_class_id'] = $this->request->post['shipping_pastmypost_tax_class_id'];
		} else {
			$data['shipping_pastmypost_tax_class_id'] = $this->config->get('shipping_pastmypost_tax_class_id');
		}

		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['shipping_pastmypost_status'])) {
			$data['shipping_pastmypost_status'] = $this->request->post['shipping_pastmypost_status'];
		} else {
			$data['shipping_pastmypost_status'] = $this->config->get('shipping_pastmypost_status');
		}

		if (isset($this->request->post['shipping_pastmypost_sort_order'])) {
			$data['shipping_pastmypost_sort_order'] = $this->request->post['shipping_pastmypost_sort_order'];
		} else {
			$data['shipping_pastmypost_sort_order'] = $this->config->get('shipping_pastmypost_sort_order');
		}

		if (isset($this->request->post['shipping_pastmypost_cod'])) {
			$data['shipping_pastmypost_cod'] = $this->request->post['shipping_pastmypost_cod'];
		} else {
			$data['shipping_pastmypost_cod'] = $this->config->get('shipping_pastmypost_cod');
		}

		if (isset($this->request->post['shipping_pastmypost_username'])) {
			$data['shipping_pastmypost_username'] = $this->request->post['shipping_pastmypost_username'];
		} else {
			$data['shipping_pastmypost_username'] = $this->config->get('shipping_pastmypost_username');
		}

		if (isset($this->request->post['shipping_pastmypost_apikey'])) {
			$data['shipping_pastmypost_apikey'] = $this->request->post['shipping_pastmypost_apikey'];
		} else {
			$data['shipping_pastmypost_apikey'] = $this->config->get('shipping_pastmypost_apikey');
		}

		if (isset($this->request->post['shipping_pastmypost_hs_code'])) {
			$data['shipping_pastmypost_hs_code'] = $this->request->post['shipping_pastmypost_hs_code'];
		} else {
			$data['shipping_pastmypost_hs_code'] = $this->config->get('shipping_pastmypost_hs_code');
		}

		if (isset($this->request->post['shipping_pastmypost_origin_country'])) {
			$data['shipping_pastmypost_origin_country'] = $this->request->post['shipping_pastmypost_origin_country'];
		} else {
			$data['shipping_pastmypost_origin_country'] = $this->config->get('shipping_pastmypost_origin_country');
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
					$data['countries'][$result['Country']['iso2']] = $result['Country']['title_'.$lang] . ' ('.$result['Country']['iso2'] .')';
				} 			
			}
		}

		if (isset($this->request->post['shipping_pastmypost_mode'])) {
			$data['shipping_pastmypost_mode'] = $this->request->post['shipping_pastmypost_mode'];
		} else {
			$data['shipping_pastmypost_mode'] = $this->config->get('shipping_pastmypost_mode');
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['shipping_pastmypost_title'])) {
			$data['shipping_pastmypost_title'] = $this->request->post['shipping_pastmypost_title'];
		} else {
			$data['shipping_pastmypost_title'] = $this->config->get('shipping_pastmypost_title');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/pastmypost', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/pastmypost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['shipping_pastmypost_username']) < 1) || (utf8_strlen($this->request->post['shipping_pastmypost_username']) > 64)) {
			$this->error['pastmypost_username'] = $this->language->get('error_pastmypost_username');
		}

		if ((utf8_strlen($this->request->post['shipping_pastmypost_apikey']) < 1) || (utf8_strlen($this->request->post['shipping_pastmypost_apikey']) > 64)) {
			$this->error['pastmypost_apikey'] = $this->language->get('error_pastmypost_apikey');
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
			`manifest_url` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`pasts_id`)
        )");

		$check = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "pasts_shipments` LIKE 'manifest_url'");
		if ($check->num_rows <= 0) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "pasts_shipments` ADD `manifest_url` VARCHAR(255) NOT NULL AFTER `shipment_number`");
		}
	}
}