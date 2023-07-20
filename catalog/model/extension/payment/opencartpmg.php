<?php
class ModelExtensionPaymentOpenCartPMG extends Model {
  public function getMethod($address, $total) {
    $this->load->language('extension/payment/opencartpmg');

    $method_data = array(
      'code'       => 'opencartpmg',
      'title'      => $this->language->get('text_title'),
      'sort_order' => $this->config->get('opencartpmg_sort_order'),
      'terms'      => ''
    );

    return $method_data;
  }
}
