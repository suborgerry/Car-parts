<?php
class ProEmailLanguage {
	private $default = 'english';
	private $directory;
	public $data = array();

	public function __construct($directory) {
		$this->directory = $directory;
		$this->load($directory);
		$this->load('module/pro_email');
	}

	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : $key);
	}

	public function load($filename) {
		$file = DIR_SYSTEM . '../catalog/language/' . $this->directory . '/' . $filename . '.php';
		
		if (file_exists($file)) {
			$_ = array();
			require($file);
			$this->data = array_merge($this->data, $_);
			return $this->data;
		}

		$file = DIR_SYSTEM . '../catalog/language/' . $this->default . '/' . $filename . '.php';

		if (file_exists($file)) {
			$_ = array();
			require($file);
			$this->data = array_merge($this->data, $_);
			return $this->data;
		} else {
			return $this->data;
			//trigger_error('Error: Could not load language ' . $filename . '!');
		}
	}
}

class ModelToolProEmail extends Model {

  private $language;
  private $basepath;
  private $http_image;
  private $order_model;
  private $order_model2;
  private $custom_field_model;
  private $template_path;
  private $admin_template;
  private $front_url;
  private $OC_V2;
  private $OC_V21;
  private $OC_V21X;
  private $OC_V22;
  private $OC_V22X;
  private $OC_V23X;
  
  public function __construct($registry) {
    parent::__construct($registry);
    
    if (defined('JOOCART_SITE_URL')) {
      $this->OC_V2 = $this->OC_V21 = $this->OC_V21 = $this->OC_V22 = $this->OC_V21X = $this->OC_V22X = $this->OC_V23X = true;
    } else {
      $this->OC_V2 = substr(VERSION, 0, 1) == 2;
      $this->OC_V21 = substr(VERSION, 0, 3) == '2.1';
      $this->OC_V22 = substr(VERSION, 0, 3) == '2.2';
      $this->OC_V21X = version_compare(VERSION, '2.1', '>=');
      $this->OC_V22X = version_compare(VERSION, '2.2', '>=');
      $this->OC_V23X = version_compare(VERSION, '2.3', '>=');
    }
    
    if (defined('PRO_EMAIL_ADMIN')) {
			$this->basepath = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG;
			$this->load->model('sale/order');
			$this->order_model = 'model_sale_order';
			$this->order_model2 = 'model_sale_order';

      //if ($this->config->get('proemail_custom_fields')) {
      if (version_compare(VERSION, '2', '>=')) {
        if (version_compare(VERSION, '2.1', '>=')) {
          $this->load->model('customer/custom_field');
          $this->custom_field_model = 'model_customer_custom_field';
        } else {
          $this->load->model('sale/custom_field');
          $this->custom_field_model = 'model_sale_custom_field';
        }
      }
		} else {
      if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
        $this->basepath = ($this->config->get('config_ssl')) ? $this->config->get('config_ssl') : HTTPS_SERVER;
      } else {
        $this->basepath = ($this->config->get('config_url')) ? $this->config->get('config_url') : HTTP_SERVER;
      }
			$this->load->model('account/order');
			$this->order_model = 'model_checkout_order';
			$this->order_model2 = 'model_account_order';
			$this->load->model('checkout/order');
			if (version_compare(VERSION, '2', '>=')) {
        $this->load->model('account/custom_field');
        $this->custom_field_model = 'model_account_custom_field';
      }
		}
    
    if (defined('DIR_CATALOG')) {
      $this->template_path = '../../../catalog/view/';
    } else {
      $this->template_path = '../';
    }
    
    $this->asset_path = DIR_SYSTEM . '../catalog/view/pro_email/';
		
    /* always use http
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->http_image = defined('_JEXEC') ? HTTPS_IMAGE : $this->basepath . 'image/';
		} else {
			$this->http_image = defined('_JEXEC') ? HTTP_IMAGE : $this->basepath . 'image/';
		}
    */
    
    if (defined('HTTP_IMAGE')) {
      $this->http_image = HTTP_IMAGE;
    } else if (defined('HTTP_CATALOG')) {
      $this->http_image = HTTP_CATALOG . 'image/';
    } else {
      $this->http_image = $this->config->get('config_url') ? $this->config->get('config_url') . 'image/' : HTTP_SERVER . 'image/';
    }
    
    // front url handler
    if (defined('PRO_EMAIL_ADMIN')) {
      if ($this->config->get('proemail_seourl')) {
        $this->front_url = new GkdUrl($this->registry);
      } else {
        $this->front_url = new Url(HTTP_CATALOG, HTTPS_CATALOG);
      }
    } else {
      $this->front_url = $this->url;
    }
  }
  
  
	/**************************
	*
	* @orders: order numbers
	* @mode: display, file, backup
	* @type: invoice, packingslip
	*
	***************************/
	public function generate($params = array()) {
    // disable webp support
    if (!defined('DISABLE_WEBP')) {
      define('DISABLE_WEBP', true);
    }
    
    if (isset($this->request->server['HTTP_ACCEPT'])) {
      $this->request->server['HTTP_ACCEPT'] = str_replace('webp', '', $this->request->server['HTTP_ACCEPT']);
    }
    
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows; U; Windows NT 10.0; en-US) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/11.0 Safari/603.1.30';
    
    $mijourl = defined('_JEXEC') ? 'option=com_mijoshop&' : '';
		$data['config'] = $this->config;
    // default config
    $default_params = array(
      'mode' => 'send',
      'conditions' => array(),
    );
    
    $params = array_merge($default_params, $params);
    
    if (!empty($params['name'])) {
      $type = 'custom.' . str_replace(array('"', "'", ' '), '_', $params['name']);;
    } else if (!empty($params['type'])) {
      $type = $params['type'];
    } else {
      $type = '';
    }
    
    if (substr($type, 0, 5) == 'admin') {
      $this->admin_template = true;
    }
    
    // theme default config
    $data['theme'] = array(
      'logo' => '',
      'logo_width' => '',
      'btn_radius' => '',
      'width' => '',
      'width_unit' => '',
      'bg_page' => '',
      'bg_page_repeat' => '',
      'bg_top' => '',
      'bg_top_repeat' => '',
      'bg_header' => '',
      'bg_header_repeat' => '',
      'bg_body' => '',
      'bg_body_repeat' => '',
      'bg_footer' => '',
      'bg_footer_repeat' => '',
      'bg_bottom' => '',
      'bg_bottom_repeat' => '',
    );
    // color default config
    $data['color'] = array(
      'text' => '',
      'text_top' => '',
      'text_head' => '',
      'text_foot' => '',
      'text_bottom' => '',
      'link' => '',
      'link_top' => '',
      'link_head' => '',
      'link_foot' => '',
      'link_bottom' => '',
      'btn' => '',
      'btn_text' => '',
      'bg_page' => '',
      'bg_top' => '',
      'bg_header' => '',
      'bg_body' => '',
      'bg_footer' => '',
      'bg_bottom' => '',
      'thead' => '',
      'theadtxt' => '',
      'tborder' => '',
    );
    
    $replace = array();
    
    if (!empty($params['order_info'])) {
      $order_info = &$params['order_info'];
    } elseif (!empty($params['order_id'])) {
      $order_info = $this->{$this->order_model}->getOrder($params['order_id']);
    }
    
    // Overwrite store settings
    $store_id = 0;
    
    if (isset($params['store_id'])) {
      $store_id = $params['store_id'];
    } else if (!empty($order_info['store_id'])) {
      $store_id = $order_info['store_id'];
    } else if (!defined('PRO_EMAIL_ADMIN') && $this->config->get('config_store_id')) {
      $store_id = $this->config->get('config_store_id');
    }
    
    if (!empty($store_id)) {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".(int) $store_id."'");
      
      foreach ($query->rows as $setting) {
        if (!$setting['serialized']) {
          $this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
        } else {
          $this->config->set($setting['key'], unserialize($setting['value']));
        }
      }
      
      $this->basepath = $this->config->get('config_url');
    }
    
    // Pro Email disabled > forward default oc email
    if ($params['mode'] != 'display' && !$this->config->get('proemail_enabled')) {
      $params['mail']->send();
      return;
    }
    
    // direct forward mail for admin
    if (!empty($params['mail']) && substr($type, 0, 5) == 'admin' && $this->config->get('proemail_admin_layout') == '_') {
      //$params['mail']->setHtml(null);
      $params['mail']->send();
      
      
      // Send to additional alert emails
      if (in_array($type, array('admin.order.confirm', 'admin.customer.register', 'admin.affiliate.register', 'admin.review'))) {
        $emails = array();
        
        if ($this->config->get('config_mail_alert')) {
          if (is_array($this->config->get('config_mail_alert'))) {
            $emails = $this->config->get('config_mail_alert');
          } else {
            $emails = explode(',', $this->config->get('config_mail_alert')); // 2.x
          }
        } else if ($this->config->get('config_alert_emails')) {
          $emails = explode(',', $this->config->get('config_alert_emails')); // 1.5
        }
        
        foreach ($emails as $email) {
          if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $params['mail']->setTo($email);
            $params['mail']->send();
          }
        }
      }
      
      return;
    }
    
    //$replace['{store_name}'] = $this->config->get('config_name');
    $replace['{store_name}'] = html_entity_decode(!empty($order_info['store_name']) ? $order_info['store_name'] : $this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
    $replace['{store_url}'] = $this->config->get('config_url') ? $this->config->get('config_url') : HTTP_CATALOG;
    $replace['{ip}'] = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : 'unknown';
    $replace['{current_user}'] = isset($this->user) && is_object($this->user) && $this->user->isLogged() ? $this->user->getUserName() : 'Guest';
    
    if (isset($params['mail'])) {
      $replace['{unsubscribe_url}'] = $this->front_url->link('tool/pro_email/unsubscribe', 'email='.$params['mail']->proEmailGetData('to'), 'SSL');
    } else {
      $replace['{unsubscribe_url}'] = $this->front_url->link('tool/pro_email/unsubscribe', 'email=test@test.com', 'SSL');
    }
    
    if ($params['mode'] == 'display') {
      if (is_file(DIR_CACHE.'previewCfg.json')) {
        $tempData = json_decode(file_get_contents(DIR_CACHE.'previewCfg.json'), 1);
        //var_dump($tempData); die;
        foreach ($tempData as $k => $v) {
          $this->config->set($k, $v);
        }
      }
    }
    
    $data['theme'] = array_merge($data['theme'], (array) $this->config->get('proemail_theme'));
		$data['color'] = array_merge($data['color'], (array) $this->config->get('proemail_color'));

    if (!empty($data['theme']['logo_width']) && !empty($data['theme']['logo'])) {
      $this->load->model('tool/image');
      list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $data['theme']['logo']);
      
      $data['theme']['logo2x'] = $this->model_tool_image->resize($data['theme']['logo'], $data['theme']['logo_width']*2, round($height_orig / ($width_orig / $data['theme']['logo_width']))*2);
      $data['theme']['logo'] = $this->model_tool_image->resize($data['theme']['logo'], $data['theme']['logo_width'], round($height_orig / ($width_orig / $data['theme']['logo_width'])));
      
      if (!$data['theme']['logo']) {
        $data['theme']['logo'] = $this->http_image . $data['theme']['logo'];
        $data['theme']['logo2x'] = $this->http_image . $data['theme']['logo'];
      }
    } else {
      $data['theme']['logo'] = !empty($data['theme']['logo']) ? $this->http_image . $data['theme']['logo'] : '';
      $data['theme']['logo2x'] = !empty($data['theme']['logo']) ? $this->http_image . $data['theme']['logo'] : '';
    }
    
    // set language id
    if (!empty($params['lang'])) {
      $lang = $params['lang'];
    } elseif (!empty($order_info)) {
      $lang = $order_info['language_id'];
    } else {
      $lang = $this->config->get('config_language_id');
    }
    
    //language
    $this->load->model('localisation/language');
    
    $user_lang = $this->model_localisation_language->getLanguage($lang);

    if (empty($user_lang)) {
      $lang = $this->config->get('config_language_id');
      $user_lang = $this->model_localisation_language->getLanguage($this->config->get('config_language_id'));
    }
    
    $lang_code = $user_lang['code'];
    
    if (defined('_JEXEC')) {
      $this->language = new ProEmailLanguage($user_lang['locale']);
    } else if (version_compare(VERSION, '2.2', '>=')) {
      $this->language = new ProEmailLanguage($user_lang['code']);
    } else {
      $this->language = new ProEmailLanguage($user_lang['directory']);
    }
    
    //$data['language'] = $this->language;
    
    // get current config
    $tpl_conf = array();

    // fix order info status id when coming from order confirm
    if (!empty($params['order_status_id']) && !empty($order_info)) {
      $order_info['order_status_id'] = $params['order_status_id'];
    }
    
    if (!empty($params['order_status_id']) && $type == 'order.update') {
      if ($params['mode'] != 'display') {
        $tpl_conf = $this->db->query("SELECT * FROM `" . DB_PREFIX . "proemail_content` WHERE type = 'order.update." . (int) $params['order_status_id'] . "' AND language_id = '". (int) $lang ."' AND store = '".(int)$store_id."'")->row;
      }
      
      if (!$tpl_conf) {
        $config_statuses = $this->config->get('proemail_status');
        
        if (is_array($config_statuses) && array_key_exists($params['order_status_id'], $config_statuses)) {
          $tpl_conf = $config_statuses[$params['order_status_id']];
          $tpl_conf['from_name'] = isset($tpl_conf['from_name'][$lang]) ? $tpl_conf['from_name'][$lang] : '';
          $tpl_conf['from_email'] = isset($tpl_conf['from_email'][$lang]) ? $tpl_conf['from_email'][$lang] : '';
          $tpl_conf['content'] = isset($tpl_conf['content'][$lang]) ? $tpl_conf['content'][$lang] : '';
          $tpl_conf['subject'] = isset($tpl_conf['subject'][$lang]) ? $tpl_conf['subject'][$lang] : '';
          $tpl_conf['file'] = isset($tpl_conf['file'][$lang]) ? $tpl_conf['file'][$lang] : '';
          $tpl_conf['template'] = isset($tpl_conf['template'][$lang]) ? $tpl_conf['template'][$lang] : '';
          $tpl_conf['to'] = '';
        }
      }
    } else {
      if ($params['mode'] != 'display') {
        $tpl_conf = $this->db->query("SELECT * FROM `" . DB_PREFIX . "proemail_content` WHERE type = '" . $this->db->escape($type) . "' AND language_id = '". (int) $lang ."' AND store = '".(int)$store_id."'")->row;
      }
      
      if (!$tpl_conf) {
        if (strpos($type, 'custom.') !== false) {
          $config_types = (array) $this->config->get('proemail_custom');
        } else {
          $config_types = (array) $this->config->get('proemail_type');
        }
        
        if (array_key_exists($type, $config_types)) {
          $tpl_conf = $config_types[$type];
          $tpl_conf['from_name'] = isset($tpl_conf['from_name'][$lang]) ? $tpl_conf['from_name'][$lang] : '';
          $tpl_conf['from_email'] = isset($tpl_conf['from_email'][$lang]) ? $tpl_conf['from_email'][$lang] : '';
          $tpl_conf['content'] = isset($tpl_conf['content'][$lang]) ? $tpl_conf['content'][$lang] : '';
          $tpl_conf['subject'] = isset($tpl_conf['subject'][$lang]) ? $tpl_conf['subject'][$lang] : '';
          $tpl_conf['file'] = isset($tpl_conf['file'][$lang]) ? $tpl_conf['file'][$lang] : '';
          $tpl_conf['template'] = isset($tpl_conf['template'][$lang]) ? $tpl_conf['template'][$lang] : '';
          $tpl_conf['to'] = '';
        }
      }
    }
    
    // direct send or no send
    if (!empty($params['mail']) && !empty($tpl_conf['template']) && $tpl_conf['template'] == '_') {
      $params['mail']->send();
      return;
    } else if (!empty($params['mail']) && !empty($tpl_conf['template']) && $tpl_conf['template'] == 'off') {
      return;
    }
    
    if (!$this->admin_template) {
      if ($params['mode'] != 'display' || !$this->config->get('proemail_type')) {
        $common_query = $this->db->query("SELECT type, content FROM `" . DB_PREFIX . "proemail_content` WHERE type LIKE 'common.%' AND language_id = '". (int) $lang ."' AND store = '".(int) $store_id."'")->rows;
        
        foreach($common_query as $val) {
          $value = html_entity_decode($val['content'], ENT_QUOTES, 'UTF-8');
          if (strip_tags($value) || strpos($value, '<img') !== false) {
            $data[str_replace('common.', '', $val['type'])] = $value;
          }
        }
      } else {
        $common_query = (array) $this->config->get('proemail_type');
        
        foreach($common_query as $key => $val) {
          if (strpos($key, 'common.') !== false && isset($val['content'][$lang])) {
            $value = html_entity_decode($val['content'][$lang], ENT_QUOTES, 'UTF-8');
            if (strip_tags($value) || strpos($value, '<img') !== false) {
              $data[str_replace('common.', '', $key)] = $value;
            }
          }
        }
      }
    }
    
		$this->load->model('setting/setting');
    
    $data['direction'] = $this->language->get('direction');
    
    $data['img_path'] = $this->http_image;
    
    if ($this->config->get('no-image')) {
      $data['img_path'] = '___';
    }
    
    //$data['logo'] = $this->http_image . $this->config->get('proemail_logo');
    $data['store_name'] = html_entity_decode(!empty($order_info['store_name']) ? $order_info['store_name'] : $this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
    $data['store_url'] = !empty($order_info['store_url']) ? $order_info['store_url'] : $this->config->get('config_url');
    
    // content forced / content from sql conf / content from tpl
    if (!empty($params['content'])) {
      $data['main_content'] = $params['content'];
    } else if (!empty($tpl_conf['content'])) {
      $data['main_content'] = html_entity_decode($tpl_conf['content'], ENT_QUOTES, 'UTF-8');
    } else {
      $data['main_content'] = html_entity_decode($this->getDefaultContent($type), ENT_QUOTES, 'UTF-8');
    }
    
    //$tpl_file = str_replace('catalog/', '', DIR_APPLICATION) . '';
    
    if ($type =='sale.contact' && isset($params['data']['message']) && strpos($params['data']['message'], '{proemail_content}') !== false) {
      $customer_language = $params['data']['language_id'];
      
      if (!empty($params['data']['customer_id'])) {
        $this->load->model('customer/customer');
        $customer_info = $this->model_customer_customer->getCustomer($params['data']['customer_id']);
        $customer_language = $customer_info['language_id'];
      }
      
      $sale_content_query = $this->db->query("SELECT * FROM `".DB_PREFIX."proemail_content` WHERE type='sale.contact' AND language_id = '".(int)$customer_language."'");
      $sale_contact_content = $sale_content_query->row['content'];
      $sale_contact_subject = $sale_content_query->row['subject'];
      $data['main_content'] = html_entity_decode($sale_contact_content, ENT_QUOTES, 'UTF-8');
      
      if (!empty($sale_contact_subject)) {
        $params['mail']->setSubject($sale_contact_subject);
      }
    }
    
    $layout = $this->config->get('proemail_layout');
    
    if (substr($type, 0, 5) == 'admin' && $this->config->get('proemail_admin_layout')) {
      $layout = $this->config->get('proemail_admin_layout');
    }
    
    if (!empty($tpl_conf['template'])) {
      $layout = $tpl_conf['template'];
    }
    
    if (file_exists(DIR_TEMPLATE . $this->template_path . 'pro_email/layout/' . $layout . '.tpl')) {
      $tpl_file = $this->template_path . 'pro_email/layout/' . $layout . '.tpl';
    } else {
      $tpl_file = $this->template_path . 'pro_email/layout/simple_clean.tpl';
    }
    
    if (version_compare(VERSION, '3', '>=')) {
      $template = new Template('template', $this->registry);
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $tpl_file = pathinfo($tpl_file, PATHINFO_DIRNAME) . '/' . pathinfo($tpl_file, PATHINFO_FILENAME);
      
      $rf = new ReflectionMethod('Template', 'render');
      
      if ($rf->getNumberOfParameters() > 2) {
        $mail_html = $template->render($tpl_file, $this->registry, false);
      } else {
        $mail_html = $template->render($tpl_file, false);
      }
      
    } else if (version_compare(VERSION, '2.2', '>=')) {
      $template = new Template($this->OC_V23X ? 'php': 'basic');
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $mail_html = $template->render($tpl_file, null);
    } elseif (method_exists($this->load, 'view')) {
      $mail_html = $this->load->view($tpl_file, $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      $mail_html = $template->fetch($tpl_file);
    }
    
    // language tag replacement
    foreach ($this->language->data as $k => $v) {
      if (is_scalar($v)) {
        $replace['['.$k.']'] = $v;
      }
    }
    
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);
    
    // customer information
    if (!empty($params['customer_id'])) {
      $customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$params['customer_id'] . "'")->row;
      
      if (!empty($customer)) {
        $params['conditions']['registered'] = true;
      }
      
      if (!empty($customer['address_id'])) {
        $address = $this->db->query("SELECT a.*, a.custom_field as address_custom_field, c.address_format, c.name as country, z.name as zone, z.code as zone_code FROM " . DB_PREFIX . "address a LEFT JOIN `" . DB_PREFIX . "country` c ON c.country_id = a.country_id LEFT JOIN `" . DB_PREFIX . "zone` z ON a.zone_id = z.zone_id WHERE a.address_id = '" . (int)$customer['address_id'] . "'")->row;
        
        if ($address) {
          unset($address['custom_field']);
          
          if (empty($address['address_format'])) {
            $address['address_format'] = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
          }
           $addr_find = array(
            '{firstname}',
            '{lastname}',
            '{company}',
            '{address_1}',
            '{address_2}',
            '{city}',
            '{postcode}',
            '{zone}',
            '{zone_code}',
            '{country}'
          );

          $addr_replace = array(
            'firstname' => $address['firstname'],
            'lastname'  => $address['lastname'],
            'company'   => $address['company'],
            'address_1' => $address['address_1'],
            'address_2' => $address['address_2'],
            'city'      => $address['city'],
            'postcode'  => $address['postcode'],
            'zone'      => $address['zone'],
            'zone_code' => $address['zone_code'],
            'country'   => $address['country']
          );

          $address['full_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($addr_find, $addr_replace, $address['address_format']))));
          $customer = array_merge($customer, $address);
        }
      }
      
      // get pwd in case it is encoded
      if (!empty($this->request->post) && !empty($this->request->post['password'])) {
        $customer['password'] = $this->request->post['password'];
      }
      
      
      if (!empty($customer['custom_field']) || !empty($customer['address_custom_field'])) {
        $custom_fields = $address_custom_field = array();
        
        if (!empty($customer['custom_field'])) {
          if (version_compare(VERSION, '2.1', '>=')) {
            $custom_fields = json_decode($customer['custom_field']);
          } else {
            $custom_fields = unserialize($customer['custom_field']);
          }
        }
        
        if (!empty($customer['address_custom_field'])) {
          if (version_compare(VERSION, '2.1', '>=')) {
            $address_custom_field = json_decode($customer['address_custom_field']);
          } else {
            $address_custom_field = unserialize($customer['address_custom_field']);
          }
        }
        
        $custom_fields = (array) $custom_fields + (array) $address_custom_field;
        
        /*foreach ($custom_fields as $cf_id => $cf_value) {
          $replace['{customer_custom_field.'.$cf_id.'}'] = $cf_value;
        }*/
        
        $cfs = $this->{$this->custom_field_model}->getCustomFields($customer['customer_group_id']);
        
        foreach ($custom_fields as $cf_id => $cf_value) {
          if(is_array($cf_value)){
            foreach ($cfs as $cfs_v) {
              if ($cfs_v['custom_field_id'] == $cf_id) {
                $cf_info = $cfs_v['custom_field_value'];
              }
            }
            
            $temp_cf_val = '';
            foreach ($cf_value as $cfv_v) {
              foreach ($cf_info as $cfi_k => $cfi_v) {
                if($cfv_v == $cfi_v['custom_field_value_id']){
                  $temp_cf_val .= $cf_info[$cfi_k]['name'] . ', ';
                }
              }
            }
            $replace['{customer_custom_field.'.$cf_id.'}'] = html_entity_decode(rtrim($temp_cf_val, ', '), ENT_QUOTES, 'UTF-8');
          } else {
            if ($cf_value > 0) {
              if (property_exists($this->{$this->custom_field_model}, 'getCustomFieldValue')) {
                $cfvQuery = $this->{$this->custom_field_model}->getCustomFieldValue($cf_value);
              }
              
              if (isset($cfvQuery['name'])) {
                $cf_value = $cfvQuery['name'];
              }
            }
            
            $replace['{customer_custom_field.'.$cf_id.'}'] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
          }
        }
      }
      
      if (!empty($customer) && is_array($customer)) {
        foreach ($customer as $k => $v) {
          if (is_scalar($v)) {
            $replace['{'.$k.'}'] = $v;
          }
        }
      }
    }
    
    // customer group info
    if (true) {
      if (isset($customer) && isset($customer['customer_group_id'])) {
        $customer_group_id = $customer['customer_group_id'];
      } else if (!empty($order_info['customer_group_id'])) {
        $customer_group_id = $order_info['customer_group_id'];
      } else if (isset($this->customer)) {
        $customer_group_id = $this->customer->getGroupId();
      } else {
        $customer_group_id = $this->config->get('config_customer_group_id');
      }
      
      $customer_group = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$lang . "'")->row;
      
      $replace['{customer_group}'] = $customer_group['name'];
      $replace['{customer_group_desc}'] = $customer_group['description'];
      
      $params['conditions']['customer_group_'.$customer_group['customer_group_id']] = true;
      $params['conditions']['approval'] = $customer_group['approval'];
    }
    
    if (isset($customer['zone_id'])) {
      $params['conditions']['customer_country_'.$customer['country']] = true;
      $params['conditions']['customer_country_id_'.$customer['country_id']] = true;
      $params['conditions']['customer_zone_'.$customer['zone']] = true;
      $params['conditions']['customer_zone_id_'.$customer['zone_id']] = true;
    }
    
    // Pay by invoice
    if (strpos($mail_html, '{po_number}') !== false) {
      $po_number = $this->db->query("SELECT po_number FROM " . DB_PREFIX . "order WHERE order_id = '" . (int)$order_info['order_id'] . "'")->row;
      
      if (!empty($po_number['po_number'])) {
        $params['conditions']['po_number'] = $replace['{po_number}'] = $po_number['po_number'];
      } else {
        $params['conditions']['po_number'] = $replace['{po_number}'] = '';
      }
    }
    
    // compatibility with SignUpCoupons
    if (strpos($mail_html, '{signupcoupon}') !== false) {
      $this->load->model('setting/setting');
      $signUpCoupons = $this->model_setting_setting->getSetting('SignUpCoupons',$customer['store_id']);	
      
      if (!empty($signUpCoupons['SignUpCoupons']['Enabled']) && $signUpCoupons['SignUpCoupons']['Enabled'] == 'yes') {
        $this->load->config('isenselabs/signupcoupons');
        $this->load->model($this->config->get('signupcoupons_path'));
        
        if (!empty($signUpCoupons['SignUpCoupons']['subject'][$this->config->get('config_language')])) {
          $subject = $signUpCoupons['SignUpCoupons']['subject'][$this->config->get('config_language')];
        }
        
        $message = $signUpCoupons['SignUpCoupons']['message'][$this->config->get('config_language')];
        $messagedata = array(
                    'SignUpCoupons' => $signUpCoupons['SignUpCoupons'], 
                    'customer_email' => $customer['email'], 
                    'message' => $message,
                    'firstname' => $customer['firstname'],
                    'lastname' => $customer['lastname']);

        $message = $this->{$this->config->get('signupcoupons_model')}->addCouponCodeToMessage($messagedata);
        //$params['mail']->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        
        $replace['{signupcoupon}'] = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
      } else {
        $replace['{signupcoupon}'] = '';
      }
    }
    
    // affiliate information
    if (!empty($params['affiliate_id'])) {
      $affiliate = $this->db->query("SELECT firstname, lastname, email, telephone, website, company FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$params['affiliate_id'] . "'")->row;
      
      foreach ($affiliate as $k => $v) {
        if (is_scalar($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }
    }
    
    // tags replacement
    
    // if ($type == 'customer.reward' && isset($params['data']['amount'])) {
      // $replace['{amount}'] = $params['data']['amount'];
    // }
    
    if (!empty($params['data'])) {
      foreach ($params['data'] as $k => $v) {
        if (is_scalar($v)) {
          if (substr($k, 0, 1) == '{' && substr($k, -1) == '}') {
            $replace[$k] = $v;
          } else {
            $replace['{'.$k.'}'] = $v;
          }
        }
      }
    }
    
    // $replace['{affiliate_url}'] = $this->url->link('affiliate/account', '', 'SSL');

    $replace['{order_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/order';
    
    //$replace['{account_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/login';
    $replace['{account_url}'] = $this->front_url->link('account/login', '', 'SSL');
    $replace['{forgot_pass_url}'] = $this->front_url->link('account/forgotten', '', 'SSL');
    //$replace['{affiliate_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=affiliate/account';
    $replace['{forgot_pass_url}'] = $this->front_url->link('affiliate/account', '', 'SSL');
    
    $replace['{store_phone}'] = $this->config->get('config_telephone');
    $replace['{store_email}'] = $this->config->get('config_email');
    
    $date_format = ($this->language->get('date_format') != 'date_format') ? $this->language->get('date_format') : 'd/m/Y';
    setlocale(LC_TIME, $lang_code);
    
    // order info handling
    if (!empty($order_info)) {
      if (!isset($order_info['customer'])) {
        $order_info['customer'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
      }
      
      // custom fields (2.0 only)
      if (defined('PRO_EMAIL_ADMIN')){
        $this->load->model('customer/custom_field');
        $this->custom_field_model = 'model_customer_custom_field';
      } else {
        $this->load->model('account/custom_field');
        $this->custom_field_model = 'model_account_custom_field';
      }
      
      if (version_compare(VERSION, '2', '>=')) {
        if (isset($order_info['custom_field']) && is_array($order_info['custom_field'])) {
          foreach ($order_info['custom_field'] as $cf_id => $cf_value) {
            $cf_info = $this->{$this->custom_field_model}->getCustomField($cf_id);
            if (isset($cf_info['type']) && ($cf_info['type'] == 'select' || $cf_info['type'] == 'checkbox' || $cf_info['type'] == 'radio') && is_scalar($cf_value)) {
              $cf_value = $this->db->query("SELECT name FROM ".DB_PREFIX."custom_field_value_description WHERE custom_field_id = '".(int)$cf_info['custom_field_id']."' AND custom_field_value_id = '".$cf_value."'")->row['name'];
            }
            
            if (is_scalar($cf_value)) {
              $replace['{custom_field.'.$cf_id.'}'] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
            }
            //$replace['{custom_field_'.$cf_id.'}'] = $cf_value;
          }
        }
        
        if (isset($order_info['payment_custom_field']) && is_array($order_info['payment_custom_field'])) {
          foreach ($order_info['payment_custom_field'] as $cf_id => $cf_value) {
            $cf_info = $this->{$this->custom_field_model}->getCustomField($cf_id);
            if (isset($cf_info['type']) && ($cf_info['type'] == 'select' || $cf_info['type'] == 'checkbox' || $cf_info['type'] == 'radio')) {
              $cf_value = $this->db->query("SELECT name FROM ".DB_PREFIX."custom_field_value_description WHERE custom_field_id = '".(int)$cf_info['custom_field_id']."' AND custom_field_value_id = '".$cf_value."'")->row['name'];
            }
            
            if (is_scalar($cf_value)) {
              $replace['{payment_custom_field.'.$cf_id.'}'] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
            }
          }
        }
        
        if (isset($order_info['shipping_custom_field']) && is_array($order_info['shipping_custom_field'])) {
          foreach ($order_info['shipping_custom_field'] as $cf_id => $cf_value) {
            $cf_info = $this->{$this->custom_field_model}->getCustomField($cf_id);
            if (isset($cf_info['type']) && ($cf_info['type'] == 'select' || $cf_info['type'] == 'checkbox' || $cf_info['type'] == 'radio')) {
              $cf_value = $this->db->query("SELECT name FROM ".DB_PREFIX."custom_field_value_description WHERE custom_field_id = '".(int)$cf_info['custom_field_id']."' AND custom_field_value_id = '".$cf_value."'")->row['name'];
            }
            
            if (is_scalar($cf_value)) {
              $replace['{shipping_custom_field.'.$cf_id.'}'] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
            }
          }
        }
      }
      
      foreach ($order_info as $k => $v) {
        if (is_scalar($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }

      if (strpos($mail_html, '{history_comment}') !== false) {
        $order_history_query = $this->db->query("SELECT comment FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_info['order_id'] . "' AND comment != '' ORDER BY order_history_id DESC LIMIT 1")->row;
        
        if (!empty($order_history_query['comment'])) {
          $replace['{history_comment}'] = nl2br($order_history_query['comment']);
          //$replace['[if_history_comment]'] = $replace['[/if_history_comment]'] = '';
          $params['conditions']['history_comment'] = true;
        } else {
          $replace['{history_comment}'] = '';
        }
      }
      if (strpos($mail_html, '{order_status}') !== false || strpos($mail_html, 'order_status:') !== false) {
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_info['order_status_id'] . "' AND language_id = '" . (int)$lang . "'")->row;
        if (!empty($order_status_query['name'])) {
          $replace['{order_status}'] = $order_status_query['name'];
          $params['conditions']['order_status:'.$order_status_query['name']] = true;
        } else {
          $replace['{order_status}'] = $this->language->get('text_no_order_status');
          $params['conditions']['order_status:none'] = true;
        }
      }
      
      if ($order_info['store_id']) {
        $query = $this->db->query("SELECT `key`, `value` FROM " . DB_PREFIX . "setting WHERE `key` IN ('config_telephone', 'config_email') AND store_id = '" . (int)$order_info['store_id'] . "'")->rows;
        
        foreach ($query as $result) {
          $store_info[$result['key']] = $result['value'];
        }
        
        if ($store_info) {
          $replace['{store_phone}'] = !empty($store_info['config_telephone']) ? $store_info['config_telephone'] : '';
          $replace['{store_email}'] = !empty($store_info['config_email']) ? $store_info['config_email'] : '';
        }
      }
    
      if ($this->config->get('ordIdMan_rand_ord_num') && isset($order_info['order_id_user'])) {
        $replace['{order_id}'] = $order_info['order_id_user'];
        $replace['{order_url}'] = $this->front_url->link('account/order/info', 'order_id=' . $order_info['order_id_user'], 'SSL');
      } else {
        $replace['{order_url}'] = $this->front_url->link('account/order/info', 'order_id=' . $order_info['order_id'], 'SSL');
      }
      
      if (!empty($order_info['order_prefix'])) {
        $replace['{order_id}'] = $order_info['order_prefix'].$replace['{order_id}'];
      }
      
      $replace['{total}'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
      
      $params['conditions']['customer'] = $order_info['customer_id'];
      $params['conditions']['comment'] = (isset($order_info['comment']) && trim($order_info['comment']));
      
      $params['conditions']['payment:'.$order_info['payment_code']] = true;
      $params['conditions']['shipping:'.$order_info['shipping_code']] = true;
      
      // Quick status updater tags
      $params['conditions']['tracking'] = !empty($order_info['tracking_no']);
      
      if (!empty($order_info['tracking_url'])) {
        $replace['{tracking_link}'] = '<a href="' . $order_info['tracking_url'] . '">' . $order_info['tracking_url'] . '</a>';
      }
      
      // custom inputs
      if (isset($this->request->post['custom_inputs'])) {
        foreach($this->request->post['custom_inputs'] as $k => $v) {
          $replace['{'.$k.'}'] = $v;
        }
      }
            
      $replace['{download_url}'] = $order_info['store_url'] . 'index.php?'.$mijourl.'route=account/download';
      
      if (strpos($mail_html, '[if_shipping_required]') !== false || strpos($mail_html, '[if_shipping_not_required]') !== false) {
        $this->load->model('catalog/product');
        $order_products = $this->{$this->order_model2}->getOrderProducts($order_info['order_id']);
        $shipping_required = false;
        
        foreach ($order_products as $op_k => $op_value) {
          $shipping_query = $this->db->query("SELECT shipping FROM `".DB_PREFIX."product` WHERE product_id = '".(int)$op_value['product_id']."'");

          if($shipping_query->row['shipping'] == 1){
            $shipping_required = true;
          }
        }
        
        if($shipping_required){
          $replace['[if_shipping_required]'] = $replace['[/if_shipping_required]'] = '';
        } else {
          $replace['[if_shipping_not_required]'] = $replace['[/if_shipping_not_required]'] = '';
        }
      }
      
      if (strpos($mail_html, '[if_download]') !== false) {
        if (version_compare(VERSION, '2', '>=')) {
          $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_info['order_id'] . "'");

          foreach ($order_product_query->rows as $order_product) {
            $product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

            if ($product_download_query->row['total']) {
              $replace['[if_download]'] = $replace['[/if_download]'] = '';
              break;
            }
          }
        } else {
          if ($this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_info['order_id'] . "'")->num_rows) {
            $replace['[if_download]'] = $replace['[/if_download]'] = '';
          }
        }
      }
    
      if (preg_match_all('/\{invoice:?(\w+)?\}/',$mail_html, $pregResults)) {
        if (!empty($params['order_comment'])) {
          $order_info['order_comment'] = $params['order_comment'];
        }
        
        foreach ($pregResults[1] as $tplName) {
          $replace['{invoice'.($tplName ? ':'.$tplName : '').'}'] = $this->getInvoice($order_info, $tplName, $lang);
        }
      }
      
      $replace['{date_added}'] = date($date_format, strtotime($order_info['date_added']));
      
      /*
      if (strpos($mail_html, '{invoice}') !== false) {
        if (!empty($params['order_comment'])) {
          $order_info['order_comment'] = $params['order_comment'];
        }
        $replace['{invoice}'] = $this->getInvoice($order_info);
      }
      */
    }
    
    $replace['{today}'] = strftime('%A');
    $replace['{now}'] = date($date_format);
    
    if (preg_match_all('/\{date:(.+?)(?::(.+?))?(?=\})/', $mail_html, $pregResults, PREG_SET_ORDER)) {
      foreach ($pregResults as $dateTag) {
        if (isset($dateTag[2])) {
          $replace[$dateTag[0].'}'] = date($dateTag[2], strtotime($dateTag[1]));
        } else if (isset($dateTag[1])) {
          $replace[$dateTag[0].'}'] = date($date_format, strtotime($dateTag[1]));
        } else {
          $replace[$dateTag[0].'}'] = date($date_format);
        }
      }
    }
    
      
    if (!empty($params['order_status_id']) && $type == 'order.update') {
      if (!empty($params['order_status_name'])) {
        $replace['{order_status}'] = $params['order_status_name'];
      } else {
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$params['order_status_id'] . "' AND language_id = '" . (int)$lang . "'")->row;
        
        $replace['{order_status}'] = isset($order_status_query['name']) ? $order_status_query['name'] : '';
      }
    }
    
    $currency = '';
    
    if (isset($order_info['currency_code'])) {
      $currency = $order_info['currency_code'];
    }
    
    // modules
    if (preg_match_all('/\{product_latest:?(\w+)?\}/', $mail_html, $pregResults)) {
      foreach ($pregResults[1] as $tplName) {
        $replace['{product_latest'.($tplName ? ':'.$tplName : '').'}'] = $this->product_advertise('latest', $tplName, $currency);
      }
    }
    
    if (preg_match_all('/\{product_featured:?(\w+)?\}/', $mail_html, $pregResults)) {
      foreach ($pregResults[1] as $tplName) {
        $replace['{product_featured'.($tplName ? ':'.$tplName : '').'}'] = $this->product_advertise('featured', $tplName, $currency);
      }
    }
    
    if (preg_match_all('/\{product_bestseller:?(\w+)?\}/', $mail_html, $pregResults)) {
      foreach ($pregResults[1] as $tplName) {
        $replace['{product_bestseller'.($tplName ? ':'.$tplName : '').'}'] = $this->product_advertise('bestseller', $tplName, $currency);
      }
    }
    
    if (preg_match_all('/\{product_special:?(\w+)?\}/', $mail_html, $pregResults)) {
      foreach ($pregResults[1] as $tplName) {
        $replace['{product_special'.($tplName ? ':'.$tplName : '').'}'] = $this->product_advertise('special', $tplName, $currency);
      }
    }
    
    if (!empty($params['conditions'])) {
      foreach ($params['conditions'] as $k => $v) {
        if ($v) {
          $replace['[if_'.$k.']'] = $replace['[/if_'.$k.']'] = '';
          $mail_html = preg_replace('/\[if_not_'.$k.'\](.*)\[\/if_not_'.$k.'\]/isU', '', $mail_html);
        } else {
          $replace['[if_not_'.$k.']'] = $replace['[/if_not_'.$k.']'] = '';
        }
      }
    }
    
    foreach ($replace as $k => $v) {
      $k = substr($k, 1, -1);
      
      if (isset($replace['[if_'.$k.']']) || isset($replace['[if_not_'.$k.']'])) continue;
      
      if ($v) {
        $replace['[if_'.$k.']'] = $replace['[/if_'.$k.']'] = '';
        $mail_html = preg_replace('/\[if_not_'.$k.'\](.*)\[\/if_not_'.$k.'\]/isU', '', $mail_html);
      } else {
        $replace['[if_not_'.$k.']'] = $replace['[/if_not_'.$k.']'] = '';
      }
    }
    
    #custom_tags
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);
    //$mail_html = preg_replace('/\[button=(.*)\](.*)\[\/button\]/isU', '<a href="$1" class="button">$2</a>', $mail_html);

    // <td class="button" bgcolor="'.$data['color']['btn'].'"
    
    $btn_radius = '';
    if (!empty($data['theme']['btn_radius'])) {
      $btn_radius = '-webkit-border-radius:'.(int) $data['theme']['btn_radius'].'px; -moz-border-radius:'.(int) $data['theme']['btn_radius'].'px; border-radius:'.(int) $data['theme']['btn_radius'].'px;';
    }
    
    $mail_html = preg_replace('/\[gg_action=(.*)\](.*)\[\/gg_action\]/isU', 
    '<div itemscope itemtype="http://schema.org/EmailMessage">
      <div itemprop="potentialAction" itemscope itemtype="http://schema.org/ViewAction">
        <link itemprop="url" href="$1"/>
        <meta itemprop="name" content="$2"/>
      </div>
    </div>', $mail_html);
    $mail_html = preg_replace('/\[button=(.*)\](.*)\[\/button\]/isU', '
    <!--[if mso]>
    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="$1" style="height:40px;v-text-anchor:middle;width:300px;margin-bottom:10px" arcsize="10%" stroke="f" fillcolor="'.$data['color']['btn'].'">
      <w:anchorlock/>
      <center style="color:'.$data['color']['btn_text'].';font-family:sans-serif;font-size:16px;font-weight:bold;">$2</center>
    </v:roundrect>
    <![endif]-->
    <!--[if !mso]> <!-->
    <table cellspacing="0" cellpadding="0" style="margin-bottom:10px"><tr>
      <td class="button" align="center" style="padding:8px 30px;'.$btn_radius.'color:'.$data['color']['btn_text'].'; display:block;">
        <a class="btn_txt" href="$1" style="color:'.$data['color']['btn_text'].'; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; display:inline-block">$2</a>
      </td>
    </tr></table>
    <!-- <![endif]-->', $mail_html);
    $mail_html = preg_replace('/\[button_center=(.*)\](.*)\[\/button_center\]/isU', '
    <!--[if mso]>
    <table style="width:100%"><tr><td class="center" style="width:100%"><center>
    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="$1" style="height:40px;v-text-anchor:middle;width:300px;margin-bottom:10px" arcsize="10%" stroke="f" fillcolor="'.$data['color']['btn'].'">
      <w:anchorlock/>
      <center style="color:'.$data['color']['btn_text'].';font-family:sans-serif;font-size:16px;font-weight:bold;">$2</center>
    </v:roundrect>
    </center></td></tr></table>
    <![endif]-->
    <!--[if !mso]> <!-->
    <table style="width:100%"><tr><td class="center" style="width:100%"><center>
    <table cellspacing="0" cellpadding="0" style="margin-bottom:10px"><tr>
      <td class="button" align="center" style="padding:8px 30px;'.$btn_radius.'color:'.$data['color']['btn_text'].'; display:block;">
        <a class="btn_txt" href="$1" style="color:'.$data['color']['btn_text'].'; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; display:inline-block">$2</a>
      </td>
    </tr></table>
    </center></td></tr></table>
    <!-- <![endif]-->', $mail_html);
    
    if (!empty($order_status_query['name'])) {
      //$mail_html = preg_replace('/\[if_not_order_status:'.$order_status_query['name'].'\](.*)\[\/if_not_order_status(:'.$order_status_query['name'].')?\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[if_not_order_status([\-\.\:\w]+)\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[\/if_not_order_status([\-\.\:\w]+)?\]/isU', '', $mail_html);
    }
    
    if (!empty($order_info['payment_code'])) {
      $mail_html = preg_replace('/\[if_not_payment:'.$order_info['payment_code'].'\](.*)\[\/if_not_payment:'.$order_info['payment_code'].'\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[if_payment([\-\.\:\w\/]+)?\](.*)\[\/if_payment([\-\.\:\w\/]+)?\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[if_not_payment([\-\.\:\w\/]+)?\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[\/if_not_payment([\-\.\:\w\/]+)?\]/isU', '', $mail_html);
    }
    
    if (!empty($order_info['shipping_code'])) {
      $mail_html = preg_replace('/\[if_not_shipping:'.$order_info['shipping_code'].'\](.*)\[\/if_not_shipping:'.$order_info['shipping_code'].'\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[if_not_shipping([\-\.\:\w]+)\]/isU', '', $mail_html);
      $mail_html = preg_replace('/\[\/if_not_shipping([\-\.\:\w]+)\]/isU', '', $mail_html);
    }
    
    $mail_html = preg_replace('/\[button href="(.*)"\](.*)\[\/button\]/isU', '<a href="$1" class="button">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[link=(.*)\](.*)\[\/link\]/isU', '<a href="$1">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[link href="(.*)"\](.*)\[\/link\]/isU', '<a href="$1">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[if_not_customer_group_([\-\.\:\w]+)\](.*)\[\/if_not_customer_group_([\-\.\:\w]+)\]/isU', '$2', $mail_html);
    $mail_html = preg_replace('/\[if_([\-\.\:\w]+)\](.*)\[\/if_([\-\.\:\w]+)\]/isU', '', $mail_html);
    $mail_html = preg_replace('/\{(shipping_|payment_)?custom_field\.\d+\}/', '', $mail_html);
    if ($params['mode'] == 'display') {$replace['<a href='] = '<a target="_blank" href=';}
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);

    if (!class_exists('Emogrifier')) {
      require_once(DIR_SYSTEM . 'library/Emogrifier.php');
    }

    // Inline images
    if ($this->config->get('no-image')) {
      $mail_html = str_replace('src="', 'src_="', $mail_html);
      $mail_html = str_replace('srcset="', 'srcset_="', $mail_html);
    }
    
    if (!empty($data['theme']['inline_images'])) {
      $dom = new DOMDocument();
      @$dom->loadHTML(mb_convert_encoding($mail_html, 'HTML-ENTITIES', 'UTF-8'));
      $images = $dom->getElementsByTagName('img');
      
      foreach ($images as $image) {
        $imgSrc = $image->getAttribute('src');
        $imgType = pathinfo($imgSrc, PATHINFO_EXTENSION);
        $imgSrc = str_replace($this->http_image, DIR_IMAGE, $imgSrc);
        if ($imgSrc) {
          $imgData = file_get_contents(str_replace('%20', ' ', $imgSrc));
        } else {
          $imgData = '';
        }
        $base64 = 'data:image/' . $imgType . ';base64,' . base64_encode($imgData);
        $image->setAttribute('src', $base64); 
      }
      
      $mail_html = $dom->saveHTML();
    }
    
    // set text content
    if (!empty($data['main_content'])) {
      $mail_text = $data['main_content'];
      $mail_text = preg_replace('/\[gg_action=(.*)\](.*)\[\/gg_action\]/isU', '', $mail_text);
      $mail_text = preg_replace('/\[button=(.*)\](.*)\[\/button\]/isU', '$2', $mail_text);
      $mail_text = preg_replace('/\[button href="(.*)"\](.*)\[\/button\]/isU', '$2', $mail_text);
      $mail_text = preg_replace('/\[link=(.*)\](.*)\[\/link\]/isU', '$2', $mail_text);
      $mail_text = preg_replace('/\[link href="(.*)"\](.*)\[\/link\]/isU', '$2', $mail_text);
      $mail_text = preg_replace('/\[if_not_customer_group_([\-\.\:\w]+)\](.*)\[\/if_not_customer_group_([\-\.\:\w]+)\]/isU', '$2', $mail_text);
      $mail_text = preg_replace('/\[if_([\-\.\:\w]+)\](.*)\[\/if_([\-\.\:\w]+)\]/isU', '', $mail_text);
      $mail_text = str_replace(array_keys($replace), array_values($replace), $mail_text);
    } else {
      $mail_text = $mail_html;
    }
    
    try {
      require_once(DIR_SYSTEM . 'library/Html2Text.php');
      if (!empty($mail_text)) {
      $mail_text = Html2Text::convert($mail_text, array('ignore_errors' => true));
      }
    } catch (Html2TextException $e) {
      echo $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine();
      die;
    }
    
    if ($this->config->get('proemail_layout') == '_text_only') {
      //$mail_html = Html2Text::convert(str_replace('&', '&amp;', $mail_html));
      if (!empty($mail_text)) {
        $mail_html = $mail_text;
      }
    } else {
      $emogrifier = new Emogrifier($mail_html);
      $mail_html = $emogrifier->emogrify();
    }
    
    if (false) {
      $params['mail'] = new Mail();
      $params['mail']->setFrom($this->config->get('config_email'));
      $params['mail']->setSender($this->config->get('config_name'));
      $params['mail']->setTo('sirius_box-dev@yahoo.fr');
      $params['mail']->setSubject('Test');
    }
    
    if (!empty($params['mail'])) {
      if ($this->config->get('proemail_attachment___')) {
        $params['mail']->addAttachment($this->config->get('proemail_attachment___'));
      }
      
      if (!empty($tpl_conf['subject'])) {
        $params['mail']->setSubject(html_entity_decode(str_replace(array_keys($replace), array_values($replace), $tpl_conf['subject']), ENT_QUOTES, 'UTF-8'));
      } else if (($this->language->get('subject_'.$type) != 'subject_'.$type) && $this->language->get('subject_'.$type)) {
        $params['mail']->setSubject(html_entity_decode(str_replace(array_keys($replace), array_values($replace), $this->language->get('subject_'.$type)), ENT_QUOTES, 'UTF-8'));
      }
      
      $from_name = $this->config->get('proemail_from_name');
      $from_email = $this->config->get('proemail_from_email');
      
      if (!empty($tpl_conf['from_name'])) {
        $params['mail']->setSender($tpl_conf['from_name']);
      } else if (!empty($from_name[$lang])) {
        $params['mail']->setSender($from_name[$lang]);
      }
      
      if (!empty($tpl_conf['from_email'])) {
        $params['mail']->setFrom($tpl_conf['from_email']);
      } else if (!empty($from_email[$lang])) {
        $params['mail']->setFrom($from_email[$lang]);
      }
      
      if (!empty($tpl_conf['to'])) {
        if (strpos($tpl_conf['to'], ',') !== false) {
          $params['mail']->setTo(explode(',', $tpl_conf['to']));
        } else {
          $params['mail']->setTo($tpl_conf['to']);
        }
      }
      
      if ($this->config->get('proemail_bcc_forward') && method_exists($params['mail'], 'addBcc')) {
        foreach (explode(';', $this->config->get('proemail_bcc_forward')) as $bccMail) {
          $params['mail']->addBcc(trim($bccMail));
        }
      }
      
      if (!empty($params['reply_to']) && method_exists($params['mail'], 'setReplyTo')) {
        $params['mail']->setReplyTo($params['reply_to']);
      }

      //$params['mail']->setText(strip_tags($data['main_content']));
      $params['mail']->setText($mail_text);
      $params['mail']->setHtml($mail_html);
      
      // attachement
      if (!empty($tpl_conf['file']) && file_exists(DIR_DOWNLOAD . 'pro_email/' . html_entity_decode($tpl_conf['file']))) {
        $params['mail']->addAttachment(DIR_DOWNLOAD . 'pro_email/' . html_entity_decode($tpl_conf['file']));
      }
      
      $params['mail']->send();
      
      # event_after_send
      
      // Send to additional alert emails
      if (in_array($type, array('admin.order.confirm', 'admin.customer.register', 'admin.affiliate.register', 'admin.review'))) {
        $emails = array();
        
        if ($this->config->get('config_mail_alert')) {
          // 2.x
          if (is_array($this->config->get('config_mail_alert'))) {
            $emails = $this->config->get('config_mail_alert');
          } else {
            $emails = explode(',', $this->config->get('config_mail_alert'));
          }
        } else if ($this->config->get('config_alert_emails')) {
          $emails = explode(',', $this->config->get('config_alert_emails')); // 1.5
        }
        
        foreach ($emails as $email) {
          if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $params['mail']->setTo($email);
            $params['mail']->send();
          }
        }
      }
      
    } elseif ($params['mode'] == 'display') {
      if ($layout == '_text_only') {
        $mail_html = '<html><body style="background:#fefefe;color:#444;font-family:arial,sans-serif;font-size:12px;padding:15px;white-space: pre-wrap;">' . $mail_html . '</body></html>';
      }
      echo $mail_html; exit;
    } else {
      return $mail_html;
    }
  }
	
  public function getDefaultContent($type) {
    if (is_file($this->asset_path . 'content/' . $type . '.tpl')) {
      $content = file_get_contents($this->asset_path . 'content/' . $type . '.tpl');
      
      if ($this->OC_V22X) {
        $content = str_replace(array('[if_OC22]','[/if_OC22]'), '', $content);
        $content = preg_replace('/\[if_not_OC22\](.*)\[\/if_not_OC22\]/isU', '', $content);
      } else {
        $content = str_replace(array('[if_not_OC22]','[/if_not_OC22]'), '', $content);
        $content = preg_replace('/\[if_OC22\](.*)\[\/if_OC22\]/isU', '', $content);
      }
      
      return $content;
    }
    
    return '';
  }
  
  private function getInvoice($order_info, $template = '', $lang = '') {
    $data['color'] = $this->config->get('proemail_color');
    
    $data['config'] = $this->config;
    $data['order'] = $order_info;

    $data['language'] = $this->language;
    
    //data
    $data['title'] = $this->language->get('heading_title');

    $data['text_invoice'] = $this->language->get('text_invoice');

    $data['text_order_id'] = $this->language->get('text_order_id');
    $data['text_invoice_no'] = $this->language->get('text_invoice_no');
    $data['text_invoice_date'] = $this->language->get('text_invoice_date');
    $data['text_date_added'] = $this->language->get('text_date_added');
    $data['text_date_due'] = $this->language->get('text_date_due');
    $data['text_telephone'] = $this->language->get('text_telephone');
    $data['text_email'] = $this->language->get('text_email');
    $data['text_fax'] = $this->language->get('text_fax');
    $data['text_url'] = $this->language->get('text_url');
    $data['text_company_id'] = $this->language->get('text_company_id');
    $data['text_tax_id'] = $this->language->get('text_tax_id');		
    $data['text_payment_method'] = $this->language->get('text_payment_method');
    $data['text_shipping_method'] = $this->language->get('text_shipping_method');

    $data['text_product'] = $this->language->get('column_product');
    $data['text_model'] = $this->language->get('column_model');
    $data['text_quantity'] = $this->language->get('column_quantity');
    $data['text_weight'] = $this->language->get('column_weight');
    $data['text_price'] = $this->language->get('column_price');
    $data['text_tax'] = $this->language->get('column_tax');
    $data['text_total'] = $this->language->get('column_total');
    
    //missing values
    $data['text_customer_id'] = $this->language->get('text_customer_id');
    $data['text_order_detail'] = $this->language->get('text_order_detail');
    $data['text_payment_address'] = $this->language->get('text_payment_address');
    $data['text_shipping_address'] = $this->language->get('text_shipping_address');
    $data['text_email'] = $this->language->get('text_email');
    $data['base'] = $this->basepath;
    
    // comment for bank instructions etc
    $data['order_comment'] = '';
    if (!empty($order_info['order_comment'])) {
      $data['order_comment'] = $order_info['order_comment'];
    }
    
    //customer comment
    $data['comment'] = '';
    if ($this->config->get('proemail_customer_comment') && isset($order_info['comment']) && trim($order_info['comment'])) {
      $data['comment'] = nl2br($order_info['comment']);
    }
    
    // custom fields (v2.x only)
    $data['custom_fields'] = array();
    
    if ($this->config->get('proemail_custom_fields')) {
      foreach ($this->config->get('proemail_custom_fields') as $custom_field_id) {
        $custom_field = $this->{$this->custom_field_model}->getCustomField($custom_field_id);
        if (isset($order_info['custom_field'][$custom_field['custom_field_id']]) && $order_info['custom_field'][$custom_field['custom_field_id']] && isset($custom_field['name'])) {
          $data['custom_fields'][] = array(
            'name' => $custom_field['name'],
            'value' => $order_info['custom_field'][$custom_field['custom_field_id']],
            'sort_order' => $custom_field['sort_order'],
          );
        }
      
        if (isset($order_info['payment_custom_field'][$custom_field['custom_field_id']]) && $order_info['payment_custom_field'][$custom_field['custom_field_id']] && isset($custom_field['name'])) {
          $data['custom_fields'][] = array(
            'name' => $custom_field['name'],
            'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
            'sort_order' => $custom_field['sort_order'],
          );
        }
      }
      
      usort($data['custom_fields'], array($this, 'cmp'));
    }

    $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
    
    if ($store_info) {
      $store_address = $store_info['config_address'];
      $store_email = $store_info['config_email'];
      $store_telephone = $store_info['config_telephone'];
      $store_fax = $store_info['config_fax'];
    } else {
      $store_address = $this->config->get('config_address');
      $store_email = $this->config->get('config_email');
      $store_telephone = $this->config->get('config_telephone');
      $store_fax = $this->config->get('config_fax');
    }
    
    if ($order_info['shipping_address_format']) {
      $format = $order_info['shipping_address_format'];
    } else {
      $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
    }

    $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
      '{address_1}',
      '{address_2}',
      '{city}',
      '{postcode}',
      '{zone}',
      '{zone_code}',
      '{country}'
    );

    $replace = array(
      'firstname' => $order_info['shipping_firstname'],
      'lastname'  => $order_info['shipping_lastname'],
      'company'   => $order_info['shipping_company'],
      'address_1' => $order_info['shipping_address_1'],
      'address_2' => $order_info['shipping_address_2'],
      'city'      => $order_info['shipping_city'],
      'postcode'  => $order_info['shipping_postcode'],
      'zone'      => $order_info['shipping_zone'],
      'zone_code' => $order_info['shipping_zone_code'],
      'country'   => $order_info['shipping_country']
    );

    // custom fields (2.0 only)
    /* todo: better way to handle shipping custom fields
    if (version_compare(VERSION, '2', '>=')) {
      if (isset($order_info['shipping_custom_field']) && is_array($order_info['shipping_custom_field'])) {
        foreach ($order_info['shipping_custom_field'] as $cf_id =>  $cf_value) {
          if (is_scalar($cf_value)) {
            $find[] = '{custom_field_'.$cf_id.'}';
            $replace[] = $cf_value;
          }
        }
      }
    }
    */
    if (version_compare(VERSION, '2', '>=')) {
      if (isset($order_info['shipping_custom_field']) && is_array($order_info['shipping_custom_field'])) {
        foreach ($order_info['shipping_custom_field'] as $cf_id =>  $cf_value) {
          $custom_field = $this->{$this->custom_field_model}->getCustomField($cf_id);
          if (is_string($cf_value)) {
            $format .= "\n" . '{custom_field_'.$cf_id.'}';
            $find[] = '{custom_field_'.$cf_id.'}';
            if (isset($custom_field['name'])) {
              $replace[] = html_entity_decode($custom_field['name'] . ': ' . $cf_value, ENT_QUOTES, 'UTF-8');
            } else {
              $replace[] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
            }
          }
        }
      }
    }
      
    $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

    if ($order_info['payment_address_format']) {
      $format = $order_info['payment_address_format'];
    } else {
      $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
    }

    $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
      '{address_1}',
      '{address_2}',
      '{city}',
      '{postcode}',
      '{zone}',
      '{zone_code}',
      '{country}'
    );

    $replace = array(
      'firstname' => $order_info['payment_firstname'],
      'lastname'  => $order_info['payment_lastname'],
      'company'   => $order_info['payment_company'],
      'address_1' => $order_info['payment_address_1'],
      'address_2' => $order_info['payment_address_2'],
      'city'      => $order_info['payment_city'],
      'postcode'  => $order_info['payment_postcode'],
      'zone'      => $order_info['payment_zone'],
      'zone_code' => $order_info['payment_zone_code'],
      'country'   => $order_info['payment_country']
    );

    // custom fields (2.0 only)
    if (version_compare(VERSION, '2', '>=')) {
      if (isset($order_info['payment_custom_field']) && is_array($order_info['payment_custom_field'])) {
        foreach ($order_info['payment_custom_field'] as $cf_id =>  $cf_value) {
          if (is_scalar($cf_value)) {
            $find[] = '{custom_field_'.$cf_id.'}';
            $replace[] = html_entity_decode($cf_value, ENT_QUOTES, 'UTF-8');
          }
        }
      }
    }
    
    $payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

    $product_data = array();
    
    //$data['columns'] = array('image', 'product', 'model', 'price');
    $data['columns'] = array('image', 'product');
    
    $products = $this->{$this->order_model2}->getOrderProducts($order_info['order_id']);
    
    foreach ($products as $product) {
      $option_data = array();

      $options = $this->{$this->order_model2}->getOrderOptions($order_info['order_id'], $product['order_product_id']);
      
      $get_full_product = true;
      $full_product = array(
        'image' => null,
        'mpn' => null,
        'manufacturer_id' => null,
        'location' => null,
        'sku' => null,
        'weight' => null,
        'weight_class_id' => null,
      );
      
      if ($get_full_product) {
        $this->load->model('catalog/product');
        $full_prod = $this->model_catalog_product->getProduct($product['product_id']);
        
        if (is_array($full_prod)) {
          $full_product = array_merge($full_product, $full_prod);
        }
      }
      
      if (1) {
        $manufacturer = $this->getManufacturer($full_product['manufacturer_id']);
      }
        
      if (1) {
        $this->load->model('tool/image');
        $full_product['image'] = $this->model_tool_image->resize($this->getProductImage($product['product_id']), $this->config->get('proemail_thumbwidth') ? $this->config->get('proemail_thumbwidth') : 40, $this->config->get('proemail_thumbheight') ? $this->config->get('proemail_thumbheight'): 40);
      }
      
      $option_data[] = array(
        'type' => 'model',
        'name'  => $this->language->get('column_model'),
        'value' => $product['model'],
      );

      foreach ($options as $option) {
        if ($option['type'] != "file") {
          $value = $option['value'];
        } else {
          $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
        }
        
        $option_data[] = array(
          'type'  => 'option',
          'name'  => $option['name'],
          'value' => $value
        );
      }
      
      if ($product['reward']) {
        $option_data[] = array(
          'type'  => 'reward',
          'name'  => $this->language->get('text_reward'),
          'value' => $product['reward']
        );
      }

      if ($full_product['price'] > 0) {
        $special_percent = (1-($product['price']/$full_product['price']))*100;
        $special_percent = $special_percent ? $special_percent.'%' : '';
      } else {
        $special_percent = '';
      }
      
      $product_data[] = array(
        'product_id' => $product['product_id'],
        'href'    => $this->front_url->link('product/product', 'product_id=' . $product['product_id']),
        'image'		=> $full_product['image'],
        'name'		=> $product['name'],
        'model'		=> $product['model'],
        'manufacturer'=> $manufacturer,
        'option'		=> $option_data,
        'quantity'	=> $product['quantity'],
        'stock_quantity'	=> $full_product['quantity'],
        'weight'		=> $full_product['weight'] ? $this->weight->format($full_product['weight'], $full_product['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point')) : null,
        //'price'		=> $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
        'price'		=> $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
        'price_tax'	=> $this->currency->format($product['price'] + $product['tax'], $order_info['currency_code'], $order_info['currency_value']),
        'special_percent'	=> $special_percent,
        'tax'			=> $this->currency->format($product['tax'], $order_info['currency_code'], $order_info['currency_value']),
        'tax_total'	=> $this->currency->format($product['tax'] * $product['quantity'], $order_info['currency_code'], $order_info['currency_value']),
        'tax_rate'	=> ($product['price'] > 0) ? round($product['tax']  / abs($product['price']) * 1, 2) * 100 . '%' : '',
        //'total'		=> $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
        'total'	=> $this->currency->format($product['total'] + ($this->config->get('proemail_total_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
        'total_tax'	=> $this->currency->format($product['total'] + ($this->config->get('proemail_total_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
        'mpn'		=> $full_product['mpn'],
        'location'	=> $full_product['location'],
        'sku'			=> $full_product['sku'],
        'upc'			=> isset($full_product['upc']) ? $full_product['upc'] : '',
      );
    }
    
    $voucher_data = $vouchers = array();
    
    // 1.5.0 - 1.5.1 compatibility
    if (version_compare(VERSION, '1.5.2', '>=')) {
      $vouchers = $this->{$this->order_model2}->getOrderVouchers($order_info['order_id']);
    }

    foreach ($vouchers as $voucher) {
      $voucher_data[] = array(
        'description' => $voucher['description'],
        'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])			
      );
    }
      
      $totals = $this->{$this->order_model2}->getOrderTotals($order_info['order_id']);
      $total_data = array();
    
    // strip html tags in total desc
    foreach ($totals as $total) {
      $total_data[] = array(
        'title' =>  strip_tags(html_entity_decode($total['title'], ENT_QUOTES, 'UTF-8')),
        'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
      );
    }
    
    if (empty($data['order_comment']) && strpos($order_info['payment_code'],'xpayment') !== false) {
      $this->load->model('extension/payment/xpayment');
      $no_of_tab = (int)str_replace('xpayment','',$order_info['payment_code']);
      
      if (is_numeric($no_of_tab)) {
        if (property_exists($this->model_extension_payment_xpayment, 'getMethodDataByID')) {
          $xpayment = $this->model_extension_payment_xpayment->getMethodDataByID($no_of_tab);
        } else {
          $xpayment = $this->model_extension_payment_xpayment->getDataByTabId($no_of_tab);
        }
        
        if (!empty($xpayment) && !empty($xpayment['email_instruction'][$order_info['language_id']])) {
          $data['order_comment'] = $this->model_extension_payment_xpayment->getInstructionView($order_info['order_id'],'mail')['instruction'];
        }
      }
    }
    
    $date_format = $this->language->get('date_format');
		if ($date_format == 'date_format') $date_format = 'd/m/Y';
      
    $data = array_merge($data, array(
      'order_id'	         => $this->config->get('ordIdMan_rand_ord_num') && !empty($order_info['order_id_user']) ? $order_info['order_id_user'] : $order_info['order_id'],
      'invoice_no'	       => $this->config->get('ordIdMan_rand_inv_num') && !empty($order_info['order_id_user']) ? $order_info['order_id_user'] : $order_info['invoice_no'],
      'invoice_prefix'     => $order_info['invoice_prefix'],
      'date_added'         => date($date_format, strtotime($order_info['date_added'])),
      'store_name'         => $order_info['store_name'],
      'store_url'          => rtrim($order_info['store_url'], '/'),
      'store_address'      => nl2br($store_address),
      'store_email'        => $store_email,
      'store_telephone'    => $store_telephone,
      'store_fax'          => $store_fax,
      'email'              => $order_info['email'],
      'telephone'          => $order_info['telephone'],
      'shipping_address'   => $shipping_address,
      'shipping_method'    => $order_info['shipping_method'],
      'payment_address'    => $payment_address,
      'payment_company_id' => isset($order_info['payment_company_id']) ? $order_info['payment_company_id'] : '',
      'payment_tax_id'     => isset($order_info['payment_tax_id']) ? $order_info['payment_tax_id'] : '',
      'payment_method'     => $order_info['payment_method'],
      'products'            => $product_data,
      'vouchers'            => $voucher_data,
      'totals'              => $total_data,
      //'comment'            => nl2br($order_info['comment'])
    ));
    
    if (!empty($order_info['order_prefix'])) {
      $data['order_id'] = $order_info['order_prefix'].$data['order_id'];
    }
    
    if (!$template) {
      $template = $this->config->get('proemail_invoice') ? $this->config->get('proemail_invoice') : 'default';
    }
    
    if (file_exists(DIR_TEMPLATE . $this->template_path . 'pro_email/invoice/' . $template . '.tpl')) {
      $tpl_file = $this->template_path . 'pro_email/invoice/' . $template . '.tpl';
    } else {
      $tpl_file = $this->template_path . 'pro_email/invoice/default.tpl';
    }
    
    if (version_compare(VERSION, '3', '>=')) {
      $template = new Template('template', $this->registry);
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $tpl_file = pathinfo($tpl_file, PATHINFO_DIRNAME) . '/' . pathinfo($tpl_file, PATHINFO_FILENAME);
      $rf = new ReflectionMethod('Template', 'render');
      
      if ($rf->getNumberOfParameters() > 2) {
        $invoice_html = $template->render($tpl_file, $this->registry, false);
      } else {
        $invoice_html = $template->render($tpl_file, false);
      }
    } else if (version_compare(VERSION, '2.2', '>=')) {
      $template = new Template($this->OC_V23X ? 'php': 'basic');
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $invoice_html = $template->render($tpl_file, null);
    } elseif (method_exists($this->load, 'view')) {
      $invoice_html = $this->load->view($tpl_file, $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      $invoice_html = $template->fetch($tpl_file);
    }
    
    $replace = array();
    
    if (strpos($invoice_html, '{order_status}') !== false && empty($order_info['order_status'])) {
      $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_info['order_status_id'] . "' AND language_id = '" . (int)$lang . "'")->row;
      if (!empty($order_status_query['name'])) {
        $order_info['order_status'] = $order_status_query['name'];
      } else {
        $order_info['order_status'] = $this->language->get('text_no_order_status');
      }
    }
    
    foreach ($order_info as $k => $v) {
      if (is_scalar($v) || is_null($v)) {
        $replace['{'.$k.'}'] = $v;
      }
    }
    
    $invoice_html = str_replace(array_keys($replace), array_values($replace), $invoice_html);
    
    return $invoice_html;
  }
    
	private function getProductImage($product_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "' LIMIT 1");
		return isset($query->row['image']) ? $query->row['image'] : '';
	}
	
	private function getManufacturer($manufacturer_id) {
		if (empty($manufacturer_id)) return '';
		
		$query = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

    if (isset($query->row['name'])) {
      return $query->row['name'];
    }
    
    return '';
	}
  
  private function product_advertise($mode, $template = '', $currency = '') {
    if (!$currency) {
      $currency = $this->config->get('config_currency');
    }
    
    if ($this->OC_V22X) {
      $this->registry->set('tax', new \Cart\Tax($this->registry));
    } else {
      if (!class_exists('Customer')) {
        require_once(DIR_SYSTEM . 'library/customer.php');
        $this->registry->set('customer', new Customer($this->registry));
      }

      if (!class_exists('Tax')) {
        require_once(DIR_SYSTEM . 'library/tax.php');
      }

      $this->registry->set('tax', new Tax($this->registry));
    }
    
    // set shipping address of store for tax calculation
    $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
    
    $data['mode'] = $mode;
    $data['language'] = $this->language;
    
    $this->load->model('catalog/product');

		$this->load->model('tool/image');
    
    $setting = $this->config->get('proemail_mod_product');
    $setting = !empty($setting[$mode]) ? $setting[$mode] : array();
		
    $setting['width'] = !empty($setting['width']) ? $setting['width'] : 100;
    $setting['height'] = !empty($setting['height']) ? $setting['height'] : 75;
    
    $setting['limit'] = !empty($setting['limit']) ? $setting['limit'] : 3;
    $setting['per_row'] = !empty($setting['per_row']) ? $setting['per_row'] : 3;

    $data['products'] = array();

		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit'],
		);
    
    if ($mode == 'featured' && !empty($setting['product']) && is_array($setting['product'])) {
      shuffle($setting['product']);
      
      while (count($setting['product']) > $setting['limit']) {
        array_pop($setting['product']);
      }
      
      $filter_data['product_ids'] = implode(',', $setting['product']);
    } else if ($mode == 'special') {
      $results = $this->getProductSpecials($setting);
    } else if ($mode == 'bestseller') {
      $results = $this->getBestSellerProducts($setting['limit']);
    }

    if (!isset($results)) {
      $results = $this->getProducts($filter_data);
    }
    
    $products = array();

		if ($results) {
      $this->tax->setStoreAddress($this->config->get('config_country_id'),$this->config->get('config_zone_id'));
      
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
          //$this->currency->format($product['price'] + $product['tax'], $order_info['currency_code'], $order_info['currency_value']);
				} else {
					$price = false;
				}
        
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $currency);
				} else {
					$tax = false;
				}
        
				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$products[] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->front_url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
      
      $currentRow = 1;
      foreach ($products as $prod) {
        if (isset($data['products'][$currentRow]) && count($data['products'][$currentRow]) == $setting['per_row']) {
          $currentRow++;
        }
        
        $data['products'][$currentRow][] = $prod;
      }
      
      $template = $template ? $template : 'product_advertise';
    
      if (file_exists(DIR_TEMPLATE . $this->template_path . 'pro_email/module/' . $template . '.tpl')) {
        $tpl_file = $this->template_path . 'pro_email/module/' . $template . '.tpl';
      } else {
        $tpl_file = $this->template_path . 'pro_email/module/product_advertise.tpl';
      }
      
      $data['settings'] = $setting;
      
      if (version_compare(VERSION, '3', '>=')) {
        $template = new Template('template', $this->registry);
        foreach ($data as $key => $value) {
          $template->set($key, $value);
        }
        $tpl_file = pathinfo($tpl_file, PATHINFO_DIRNAME) . '/' . pathinfo($tpl_file, PATHINFO_FILENAME);
        
        $rf = new ReflectionMethod('Template', 'render');
        
        if ($rf->getNumberOfParameters() > 2) {
          $html = $template->render($tpl_file, $this->registry, false);
        } else {
          $html = $template->render($tpl_file, false);
        }
      } else if (version_compare(VERSION, '2.2', '>=')) {
        $template = new Template($this->OC_V23X ? 'php': 'basic');
        foreach ($data as $key => $value) {
          $template->set($key, $value);
        }
        $html = $template->render($tpl_file, null);
      } elseif (method_exists($this->load, 'view')) {
        $html = $this->load->view($tpl_file, $data);
      } else {
        $template = new Template();
        $template->data = &$data;
        $html = $template->fetch($tpl_file);
      }
      
      return $html;
		}
  }
  
  public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}
  
  public function getProducts($data = array()) {
		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		$sql .= " AND p.image <> ''";
    
    if (isset($data['product_ids'])) {
      $sql .= " AND p.product_id IN (".$data['product_ids'].")";
    }
    
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}
  
  public function getProductSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}

			if (!isset($data['limit']) || $data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

  private function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}
  
  private function cmp($a, $b) {
		if ($a['sort_order'] == $b['sort_order']) return 0;
		return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
	}
}

class GkdUrl{
	private $registry;
	private $ssl;
	private $rewrite = array();

	public function __construct($registry = false, $ssl = false) {
		$this->registry = $registry;
		$this->ssl = $ssl;
    
    if ($this->registry->get('config')->get('config_seo_url')) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/startup/seo_url.php';
      } else {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/common/seo_url.php';
      }
      
      if (isset($vqmod)) {
        if (function_exists('modification')) {
          require_once($vqmod->modCheck(modification($seourl_file)));
        } else {
          require_once($vqmod->modCheck($seourl_file));
        }
      } else if (class_exists('VQMod')) {
        if (function_exists('modification')) {
          require_once(VQMod::modCheck(modification($seourl_file)));
        } else {
          require_once(VQMod::modCheck($seourl_file));
        }
      } else {
        if (function_exists('modification')) {
          require_once(modification($seourl_file));
        } else {
          require_once($seourl_file);
        }
      }
      
      if (version_compare(VERSION, '2.2', '>=')) {
        $this->rewrite[] = new ControllerStartupSeoUrl($this->registry);
      } else {
        $this->rewrite[] = new ControllerCommonSeoUrl($this->registry);
      }
    }
	}

	public function link($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
      if (defined('PRO_EMAIL_ADMIN')) {
        $url = ($this->registry->get('config')->get('config_ssl') ? $this->registry->get('config_ssl')->get('config_url') : HTTPS_CATALOG) . 'index.php?route=' . $route;
      } else {
        $url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
      }
		} else {
      if (defined('PRO_EMAIL_ADMIN')) {
        $url = ($this->registry->get('config')->get('config_url') ? $this->registry->get('config')->get('config_url') : HTTP_CATALOG)  . 'index.php?route=' . $route;
      } else {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
      }
		}
		
		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}

		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}

		return $url;
	}
}