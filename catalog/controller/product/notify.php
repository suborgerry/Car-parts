<?php
class ControllerProductNotify extends Controller
{
    public function notify()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);

            $product_id = $data['product_id'];
            $email = $data['email'];

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_notification WHERE product_id = '" . $this->db->escape($product_id) . "' AND email = '" . $this->db->escape($email) . "'");

            if ($query->num_rows == 0) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_notification SET product_id = '" . $this->db->escape($product_id) . "', email = '" . $this->db->escape($email) . "'");

                $response = array(
                    'message' => 'Subscribed!'
                );
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($response));
            } else {
                $response = array(
                    'message' => 'You are already subscribed.'
                );
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($response));
            }
        }
    }
}