<?php
class ControllerExtensionModulePastscourier extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/pastscourier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		$this->install();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('pastscourier', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['error_secretkey'] = $this->error['secretkey'] ?? '';

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}		

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['area'])) {
			$data['error_area'] = $this->error['area'];
		} else {
			$data['error_area'] = '';
		}

		if (isset($this->error['zipcode'])) {
			$data['error_zipcode'] = $this->error['zipcode'];
		} else {
			$data['error_zipcode'] = '';
		}

		if (isset($this->error['date'])) {
			$data['error_date'] = $this->error['date'];
		} else {
			$data['error_date'] = '';
		}

		if (isset($this->error['time_from'])) {
			$data['error_time_from'] = $this->error['time_from'];
		} else {
			$data['error_time_from'] = '';
		}

		if (isset($this->error['time_to'])) {
			$data['error_time_to'] = $this->error['time_to'];
		} else {
			$data['error_time_to'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/pastscourier', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/pastscourier', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/pastscourier', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/pastscourier', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['secretkey'])) {
			$data['secretkey'] = $this->request->post['secretkey'];
		} elseif (!empty($module_info)) {
			$data['secretkey'] = $module_info['secretkey'];
		} else {
			$data['secretkey'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($module_info)) {
			$data['phone'] = $module_info['phone'];
		} else {
			$data['phone'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($module_info)) {
			$data['email'] = $module_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($module_info)) {
			$data['city'] = $module_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['area'])) {
			$data['area'] = $this->request->post['area'];
		} elseif (!empty($module_info)) {
			$data['area'] = $module_info['area'];
		} else {
			$data['area'] = '';
		}

		if (isset($this->request->post['district'])) {
			$data['district'] = $this->request->post['district'];
		} elseif (!empty($module_info)) {
			$data['district'] = $module_info['district'];
		} else {
			$data['district'] = '';
		}

		if (isset($this->request->post['village'])) {
			$data['village'] = $this->request->post['village'];
		} elseif (!empty($module_info)) {
			$data['village'] = $module_info['village'];
		} else {
			$data['village'] = '';
		}

		if (isset($this->request->post['street'])) {
			$data['street'] = $this->request->post['street'];
		} elseif (!empty($module_info)) {
			$data['street'] = $module_info['street'];
		} else {
			$data['street'] = '';
		}

		if (isset($this->request->post['house'])) {
			$data['house'] = $this->request->post['house'];
		} elseif (!empty($module_info)) {
			$data['house'] = $module_info['house'];
		} else {
			$data['house'] = '';
		}

		if (isset($this->request->post['apartment_nr'])) {
			$data['apartment_nr'] = $this->request->post['apartment_nr'];
		} elseif (!empty($module_info)) {
			$data['apartment_nr'] = $module_info['apartment_nr'];
		} else {
			$data['apartment_nr'] = '';
		}

		if (isset($this->request->post['zipcode'])) {
			$data['zipcode'] = $this->request->post['zipcode'];
		} elseif (!empty($module_info)) {
			$data['zipcode'] = $module_info['zipcode'];
		} else {
			$data['zipcode'] = '';
		}

		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($module_info)) {
			$data['date'] = $module_info['date'];
		} else {
			$data['date'] = '';
		}

		if (isset($this->request->post['time_from'])) {
			$data['time_from'] = $this->request->post['time_from'];
		} elseif (!empty($module_info)) {
			$data['time_from'] = $module_info['time_from'];
		} else {
			$data['time_from'] = '';
		}

		if (isset($this->request->post['time_to'])) {
			$data['time_to'] = $this->request->post['time_to'];
		} elseif (!empty($module_info)) {
			$data['time_to'] = $module_info['time_to'];
		} else {
			$data['time_to'] = '';
		}

		if (isset($this->request->post['transport_type'])) {
			$data['transport_type'] = $this->request->post['transport_type'];
		} elseif (!empty($module_info)) {
			$data['transport_type'] = $module_info['transport_type'];
		} else {
			$data['transport_type'] = '';
		}

		if (isset($this->request->post['parcel_strids'])) {
			$data['parcel_strids'] = $this->request->post['parcel_strids'];
		} elseif (!empty($module_info)) {
			$data['parcel_strids'] = $module_info['parcel_strids'];
		} else {
			$data['parcel_strids'] = '';
		}

		if (isset($this->request->post['manifest'])) {
			$data['manifest'] = $this->request->post['manifest'];
		} elseif (!empty($module_info)) {
			$data['manifest'] = $module_info['manifest'];
		} else {
			$data['manifest'] = '';
		}

		if (isset($this->request->post['cbm'])) {
			$data['cbm'] = $this->request->post['cbm'];
		} elseif (!empty($module_info)) {
			$data['cbm'] = $module_info['cbm'];
		} else {
			$data['cbm'] = '';
		}

		if (isset($this->request->post['ldm'])) {
			$data['ldm'] = $this->request->post['ldm'];
		} elseif (!empty($module_info)) {
			$data['ldm'] = $module_info['ldm'];
		} else {
			$data['ldm'] = '';
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($module_info)) {
			$data['weight'] = $module_info['weight'];
		} else {
			$data['weight'] = '';
		}

		if (isset($this->request->post['comments'])) {
			$data['comments'] = $this->request->post['comments'];
		} elseif (!empty($module_info)) {
			$data['comments'] = $module_info['comments'];
		} else {
			$data['comments'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/pastscourier', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/pastscourier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['secretkey']) < 1) || (utf8_strlen($this->request->post['secretkey']) > 64)) {
			$this->error['secretkey'] = $this->language->get('error_secretkey');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 64)) {
			$this->error['phone'] = $this->language->get('error_phone');
		}

		if ((utf8_strlen($this->request->post['city']) < 3) || (utf8_strlen($this->request->post['city']) > 64)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		if ((utf8_strlen($this->request->post['area']) < 3) || (utf8_strlen($this->request->post['area']) > 64)) {
			$this->error['area'] = $this->language->get('error_area');
		}

		if (!$this->request->post['zipcode']) {
			$this->error['zipcode'] = $this->language->get('error_zipcode');
		}

		if (!$this->request->post['date']) {
			$this->error['date'] = $this->language->get('error_date');
		}

		if (!$this->request->post['time_from']) {
			$this->error['time_from'] = $this->language->get('error_time_from');
		}

		if (!$this->request->post['time_to']) {
			$this->error['time_to'] = $this->language->get('error_time_to');
		}

		return !$this->error;
	}

	public function submitRequest(){

		$json = array();

		$this->load->language('extension/module/pastscourier');

		$url = 'https://express.pasts.lv/courierApplicationsApi/create';		
		
		$courier_data = array(
							
			array(				
				"when" => $this->request->post['date'],
				"time_from" => $this->request->post['time_from'],
				"time_to" => $this->request->post['time_to'],
				"transport_type" => $this->request->post['transport_type'],
				"parcel_strids" => $this->request->post['parcel_strids'],
				"manifest" => $this->request->post['manifest'],
				"cbm" => $this->request->post['cbm'],
				"ldm" => $this->request->post['ldm'],
				"weight" => $this->request->post['weight'],
				"company_name" => $this->request->post['name'],		
				"phone" => $this->request->post['phone'],
				"email" => $this->request->post['email'],
				"comments" => $this->request->post['comments'],
				"city" => $this->request->post['city'],
				"area" => $this->request->post['area'],
				"district" => $this->request->post['district'],
				"village" => $this->request->post['village'],
				"street" => $this->request->post['street'],
				"house" => $this->request->post['house'],
				"apartment_nr" => $this->request->post['apartment_nr'],
				"zipcode" => $this->request->post['zipcode'],
			)			
		);			

		$post_data = array(
 			"secret" => $this->request->post['secretkey'],
 			"applications" => $courier_data
 		);   		

		$response = $this->send($url, json_encode($post_data), false); 

		if (!is_array($response)) {
			$res_data = json_decode($response, true); 
	//echo '<pre>'; print_r($res_data); exit;
			if(!$res_data){			 		
			 	$json['error'] = 'No Response Data Found!';
			}elseif( isset($res_data['error']) ){
				$json['error'] = $res_data['error'];
			}elseif( isset($res_data['result']) ){

				foreach($res_data['result'] as $result){
					if (is_array($result)) {
						$json['error'] = implode('<br/>',$result);
					}
				}				
			}
					
		}else{
			if($response['text']){
		 		$json['error'] = $response['text'];
		 	}else{
		 		$json['error'] = 'Request Error!';
		 	}
		}		

		if(!$json){
			$json['success'] = $this->language->get('text_success_submit');	
		}		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function send($url, $data = null, $checkCert = true)
	{ 
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

	public function install(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pasts_courier` (
            `pasts_id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` int(11) NOT NULL,
            `courier_request` VARCHAR(50) NOT NULL,
            `status` VARCHAR(50) NOT NULL,
            PRIMARY KEY (`pasts_id`)
        )");
	}
}
