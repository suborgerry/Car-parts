<?php
class ModelExtensionShippingPastexpress extends Model {
	public function getQuote($address) {
		$this->load->language('extension/shipping/pastexpress');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('shipping_pastexpress_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}

			if ($status) {
				$cost = '';

				$weight = $this->cart->getWeight();

				$rates = explode(',', $this->config->get('shipping_pastexpress_' . $result['geo_zone_id'] . '_rate'));

				foreach ($rates as $rate) {
					$data = explode(':', $rate);

					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}

						break;
					}
				}

				if (isset($this->config->get('shipping_pastexpress_title')[$this->config->get('config_language_id')]['title']) && $this->config->get('shipping_pastexpress_title')[$this->config->get('config_language_id')]['title'] != '') {
				
					$result['name'] = $this->config->get('shipping_pastexpress_title')[$this->config->get('config_language_id')]['title'];
				}else{
					$result['name'] = $this->language->get('text_additional_shipping_title');
				}

				if ((string)$cost != '') {
					$quote_data['pastexpress_' . $result['geo_zone_id']] = array(
						'code'         => 'pastexpress.pastexpress_' . $result['geo_zone_id'],
						'title'        => $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('shipping_pastexpress_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('shipping_pastexpress_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);
				}
			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'pastexpress',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_pastexpress_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}