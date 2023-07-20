<?php
class ControllerToolProEmail extends Controller {
  
	public function sendmail() {
    // sendmail is enabled or disabled
    if (true) {
      return;
    }
    
    // basic checks
    if (empty($this->request->get['secure']) || $this->request->get['secure'] !== '123456789') {
      die('Invalid secure key');
    }
    
    if (empty($this->request->post['type']) && empty($this->request->post['name'])) {
      die('Missing email type');
    }
    
    if (empty($this->request->get['to'])) {
      die('Missing to email');
    }
    
    // prepare mail object
    if (version_compare(VERSION, '3', '>=')) {
      $mail = new Mail($this->config->get('config_mail_engine'));
    } else {
      $mail = new Mail();
      $mail->protocol = $this->config->get('config_mail_protocol');
    }
    
    $mail->parameter = $this->config->get('config_mail_parameter');
    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
    
    $mail->setTo($this->request->get['to']);
    $mail->setFrom($this->config->get('config_email'));
    $mail->setSender($this->config->get('config_name'));
    
    if (!empty($this->request->get['subject'])) {
      $mail->setSubject($this->request->get['subject']);
    } else {
      $mail->setSubject($this->config->get('config_name'));
    }
    
    $this->load->model('tool/pro_email');
    
    $params = $this->request->post;
    
    $params['mail'] = $mail;
    
    $this->model_tool_pro_email->generate($params);
    
    return;
  }
  
	public function unsubscribe() {
		$this->load->language('extension/module/pro_email');
    
		$this->document->setTitle(($this->language->get('text_unsubscribe_title') != 'text_unsubscribe_title') ? $this->language->get('text_unsubscribe_title') : 'Unsubscribe from newsletter');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
    
    if (!empty($this->request->get['email'])) {
      $email = $this->request->get['email'];
      
      $this->db->query("UPDATE  " . DB_PREFIX . "customer SET newsletter = 0 WHERE email = '" . $this->db->escape($email) . "'");
    }
    
    $data['text_message'] = ($this->language->get('text_unsubscribe_success') != 'text_unsubscribe_success') ? '<h2>'.$this->language->get('text_unsubscribe_title').'</h2><p>'.$this->language->get('text_unsubscribe_success').'</p>' : '<h2>Unsubscribe from newsletter</h2><p>You have successfully been unsbscribed from this newsletter.</p>';

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}
  
}